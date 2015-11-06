<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 10.08.15
 * Time: 21:07
 */

class Mail {

    private $from;
    private $from_name = "";
    private $type = "text/html";
    private $encoding = "utf-8";
    private $notify = false;
    private $recipient_name = "";
    private $smtpServer = SMTPHOST;
    private $smtpLogin = SMTPLOGIN;
    private $smtpPass = SMTPPASS;
    private $smtpPort = SMTPORT;

    /* Конструктор принимающий обратный e-mail адрес */
    public function __construct($from) {
        $this->from = $from;
    }

    /* Изменение обратного e-mail адреса */
    public function setFrom($from) {
        $this->from = $from;
    }

    /* Изменение имени в обратном адресе */
    public function setFromName($from_name) {
        $this->from_name = $from_name;
    }

    /* Изменение типа содержимого письма */
    public function setType($type) {
        $this->type = $type;
    }

    /* Нужно ли запрашивать подтверждение письма */
    public function setNotify($notify) {
        $this->notify = $notify;
    }

    /* Изменение кодировки письма */
    public function setEncoding($encoding) {
        $this->encoding = $encoding;
    }
    /* Изменение имени получателя */
    public function setRecipientName($recipient_name) {
        $this->recipient_name = $recipient_name;
    }
    /* Изменение адреса SMTP сервера */
    public function setSmtpServer($serverAdress){
        $this->smtpServer = $serverAdress;
    }
    /* Изменение логина юзера SMTP сервера */
   public function setSmtpLogin($login){
       $this->smtpLogin = $login;
   }
    /* Изменение пароля юзера SMTP сервера */
   public function setSmtpPass($pass){
        $this->smtpPass = $pass;
    }

   public function setSmtpPort($port){
       $this->smtpPort = $port;
   }


    /* Метод отправки письма */
    public function send($to, $subject, $message) {
        $from = "=?utf-8?B?".base64_encode($this->from_name)."?="." <".$this->from.">"; // Кодируем обратный адрес (во избежание проблем с кодировкой)
        $headers = "From: ".$from."\r\nReply-To: ".$from."\r\nContent-type: ".$this->type."; charset=".$this->encoding."\r\n"; // Устанавливаем необходимые заголовки письма
        if ($this->notify) $headers .= "Disposition-Notification-To: ".$this->from."\r\n"; // Добавляем запрос подтверждения получения письма, если требуется
        $subject = "=?utf-8?B?".base64_encode($subject)."?="; // Кодируем тему (во избежание проблем с кодировкой)
        return mail($to, $subject, $message, $headers); // Отправляем письмо и возвращаем результат
    }
    /* Метод отправки письма через SMTP */
    /* Получение данных от SMTP сервера */
    private function get_data($smtp_conn)
    {
        $data="";
        while($str = fgets($smtp_conn,515)){
            $data .= $str;
            if(substr($str,3,1) == " ") {
                break;
            }
        }
        return $data;
    }

    public function smtpSend($to, $subject, $message){
        $header="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
        $header.="From: =?".$this->encoding."?Q?".str_replace("+","_",str_replace("%","=",urlencode($this->from_name)))."?= <$this->from>\r\n";
        $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
        $header.="Reply-To: =?".$this->encoding."?Q?".str_replace("+","_",str_replace("%","=",urlencode($this->from_name)))."?= <$this->from>\r\n";
        $header.="X-Priority: 3 (Normal)\r\n";
        $header.="Message-ID: <172562218.".date("YmjHis")."@gmail.com>\r\n";
        $header.="To: =?".$this->encoding."?Q?".str_replace("+","_",str_replace("%","=",urlencode($this->recipient_name)))."?= <$to>\r\n";
        $header.="Subject: =?".$this->encoding."?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?=\r\n";
        $header.="MIME-Version: 1.0\r\n";
        $header.="Content-Type: ".$this->type."; charset=".$this->encoding."\r\n";
        $header.="Content-Transfer-Encoding: 8bit\r\n";

        $smtp_conn = fsockopen($this->smtpServer, $this->smtpPort, $errno, $errstr, 10);
        if(!$smtp_conn) {
            fclose($smtp_conn);
            return [false, "соединение с серверов не прошло"];
        }
        $data = $this->get_data($smtp_conn);
        fputs($smtp_conn,"EHLO vasya\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 250) {
            fclose($smtp_conn);
            return [false, "ошибка приветсвия EHLO"];
        }
        fputs($smtp_conn,"AUTH LOGIN\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 334) {
            fclose($smtp_conn);
            return [false, "сервер не разрешил начать авторизацию"];
        }

        fputs($smtp_conn,base64_encode($this->smtpLogin)."\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 334) {
            fclose($smtp_conn);
            return [false, "ошибка доступа к такому юзеру"];
        }

        fputs($smtp_conn,base64_encode($this->smtpPass)."\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 235) {
            fclose($smtp_conn);
            return [false, "не правильный пароль"];
        }

        $size_msg=strlen($header."\r\n".$message);

        fputs($smtp_conn,"MAIL FROM:<$this->from> SIZE=".$size_msg."\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 250) {
            fclose($smtp_conn);
            return [false, "сервер отказал в команде MAIL FROM"];
        }
        fputs($smtp_conn,"RCPT TO:<$to>\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 250 AND $code != 251) {
            fclose($smtp_conn);
            return [false, "Сервер не принял команду RCPT TO"];
        }
        fputs($smtp_conn,"DATA\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 354) {
            fclose($smtp_conn);
            return [false, "сервер не принял DATA"];
        }
        fputs($smtp_conn,$header."\r\n".$message."\r\n.\r\n");
        $code = substr($this->get_data($smtp_conn),0,3);
        if($code != 250) {
            fclose($smtp_conn);
            return [false, "ошибка отправки письма"];
        }

        fputs($smtp_conn,"QUIT\r\n");
        fclose($smtp_conn);
        return [true, "письмо отправлено успешно"];
    }

}