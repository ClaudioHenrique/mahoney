<?php
App::uses('CakeEmail', 'Network/Email');
/**
 * The Mailer component has common behaviors to mail actions
 */
class MailerComponent extends Component {

    public $Email;
    
    function __construct() {
        $this->Email = new CakeEmail();
    }
    
    /**
     * Sends an email
     * 
     * @param String $to The email to send
     * @param String $subject The email subject
     * @param String $layout A layout file
     * @param String $view A view file
     * @param Array $vars Associative array with template variables
     */
    public function send($to = null, $subject = null, $view = null, $layout = null, $vars = null) {
        try {
            $this->Email->config(
                array(
                    "host" => Configure::read("Email.host"),
                    "port" => Configure::read("Email.port"),
                    "transport" => Configure::read("Email.transport"),
                    "username" => Configure::read("Email.username"),
//                    "password" => Configure::read("Email.password")
                    "password" => "974860ad"
                )
            );
            $this->Email->template($layout, $view);
            $this->Email->emailFormat('html');
            $this->Email->viewVars($vars);
            $this->Email->from(array(Configure::read("Email.from") => Configure::read("Email.fromName")));
            $this->Email->to($to);
            $this->Email->subject($subject);
            $this->Email->send();
        } catch(Exception $ex) {
            //CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), AuthComponent::user()["username"], sprintf(__d("system","Mailer")), __d("system", "to send"), $to, sprintf(__d("system","email")), $ex->getMessage()));
            throw new Exception(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to send"), $to, __d("system","email")));
        }
    }
    
}
