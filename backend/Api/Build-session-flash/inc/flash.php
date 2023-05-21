<?php

class FlashMessage {
    private string $FLASH = 'FLASH_MESSAGES';
    private string $FLASH_ERROR = 'error';
    private string $FLASH_WARNING = 'warning';
    private string $FLASH_INFO = 'info';
    private string $FLASH_SUCCESS = 'success';
    public function create_flash_message(string $name, string $message, string $type):void
    {
       if(isset($_SESSION[$this->FLASH][$name])){
           unset($_SESSION[$this->FLASH][$name]);
       }
       $_SESSION[$this->FLASH][$name] = ['message' => $message, 'type' => $type];
    }
    public function flash(string $name = '', string $message = '', string $type = ''): void
    {
        if ($name !== '' && $message !== '' && $type !== '') {
            // create a flash message
            $this->create_flash_message($name, $message, $type);
        } elseif ($name !== '' && $message === '' && $type === '') {
            // display a flash message
            $this->display_flash_message($name);
        } elseif ($name === '' && $message === '' && $type === '') {
            // display all flash message
            $this->display_all_flash_messages();
        }
    }
    public function display_flash_message(string $name): void
    {
        if (!isset($_SESSION[$this->FLASH][$name])) {
            return;
        }

        // get message from the session
        $flash_message = $_SESSION[$this->FLASH][$name];

        // delete the flash message
        unset($_SESSION[$this->FLASH][$name]);

        // display the flash message
        echo $this->format_flash_message($flash_message);
    }

    /**
     * Display all flash messages
     *
     * @return void
     */
    public function display_all_flash_messages(): void
    {
        if (!isset($_SESSION[$this->FLASH])) {
            return;
        }

        // get flash messages
        $flash_messages = $_SESSION[$this->FLASH];

        // remove all the flash messages
        unset($_SESSION[$this->FLASH]);

        // show all flash messages
        foreach ($flash_messages as $flash_message) {
            echo $this->format_flash_message($flash_message);
        }
    }
    public function format_flash_message(array $flash_message): string
    {
        return sprintf('<div class="alert alert-%s">%s</div>',
            $flash_message['type'],
            $flash_message['message']
        );
    }
}