<?php

class Controller_Wedding extends Controller {

    public function action_home()
    {
        $this->view = Kostache::factory('wedding/home');

        if ($this->request->query('sent') === 'yes')
        {
            $this->view->sent = TRUE;
        }

        if ($this->request->method() === Request::POST)
        {
            $post = Arr::extract($this->request->post(), array(
                'your_name',
                'email_address',
                'phone_number',
                'total_guests',
                'not_attending',
                ));

            $post = Validation::factory($post)
                ->rule('your_name', 'not_empty')
                ->rule('email_address', 'not_empty')
                ->rule('email_address', 'email')
                ->rule('phone_number', 'not_empty')
                ->rule('phone_number', 'phone')
                ->rule('total_guests', 'digit')
                ->rule('not_attending', 'in_array', array(':value', array('yes')))
                ;

            if ($post->check())
            {
                $email = Email::factory()
                    ->to('us@gwenandwoody.com', 'Gwen & Woody')
                    ->from($post['email_address'], $post['your_name'])
                    ->bcc('woody.gilk@gmail.com', 'Woody Gilk')
                    ->subject('Wedding RSVP!')
                    ->message($this->_message($post->as_array()))
                    ;

                $email->send();

                $this->request->redirect('?sent=yes');
            }
            else
            {
                $this->view->errors = $post->errors('rsvp');
                $this->view->post = $post;
            }
        }
    }

    protected function _message($post)
    {
        $body = ($post['not_attending']
                  ? ':your_name will not be attending. How sad.'
                  : ':your_name will be attending, for a total of :total_guests guests.'
              )."\nPhone number: :phone_number"
              ;

        $values = array();

        foreach ($post as $key => $value)
        {
            $values[":{$key}"] = $value;
        }

        return strtr($body, $values);
    }

	public function action_page()
	{
		$page = $this->request->param('page');

        if (empty($page) OR $page === 'home')
        {
            $this->request->redirect('', 301);
        }

		$this->view = Kostache::factory("wedding/{$page}");
	}

	public function after()
	{
		$this->response->body($this->view->render());
		parent::after();
	}

}
