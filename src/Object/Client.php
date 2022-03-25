<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Class Client.
 * Покупатель
 *
 * @package SSitdikov\ATOL\Object
 */
class Client implements \JsonSerializable
{

    /**
     * Email покупателя
     * 
     * @var string
     */
    private $email = '';

    /**
     * Телефон покупателя
     * 
     * @var string
     */
    private $phone = '';

    public function __construct($email, $phone)
    {
        $this->setEmail($email);
        $this->setPhone($phone);
    }


    public function jsonSerialize(): array
    {
        return [
            'email' => $this->getEmail(),
            'phone' => $this->getPhone()
        ];
    }

  
    /**
     * Получить email клиента
     * 
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }


    /**
     * Задать email клиента
     * 
     * @param string $email
     * 
     * @return Client
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    
    
    /**
      * Получить телефон клиента

     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }


    /**
     * Задать телефон клиента
     * 
     * @param string $phone
     * 
     * @return Client
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }
}
