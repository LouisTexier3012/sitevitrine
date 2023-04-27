<?php

namespace App\Anniversaire\Modele\DataObject;

class Message extends AbstractDataObject {

    private string $signature;
    private string $message;
    private ?string $lien1;
    private ?string $lien2;
    private ?string $lien3;

    /**
     * @param string $signature
     * @param string $message
     * @param string|null $lien1
     * @param string|null $lien2
     * @param string|null $lien3
     */
    public function __construct(string $signature, string $message, string $lien1 = null, string $lien2 = null, string $lien3 = null)
    {
        $this->signature = $signature;
        $this->message = $message;
        $this->lien1 = $lien1;
        $this->lien2 = $lien2;
        $this->lien3 = $lien3;
    }


    public static function create(string $message, string $signature, string $lien1 = null, string $lien2 = null, string $lien3 = null) : Message {
        return new Message($signature,$message,$lien1,$lien2,$lien3);
    }



    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     */
    public function setSignature(string $signature): void
    {
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getLien1(): string
    {
        return $this->lien1;
    }

    /**
     * @param string $lien1
     */
    public function setLien1(string $lien1): void
    {
        $this->lien1 = $lien1;
    }

    /**
     * @return string
     */
    public function getLien2(): string
    {
        return $this->lien2;
    }

    /**
     * @param string $lien2
     */
    public function setLien2(string $lien2): void
    {
        $this->lien2 = $lien2;
    }

    /**
     * @return string
     */
    public function getLien3(): string
    {
        return $this->lien3;
    }

    /**
     * @param string $lien3
     */
    public function setLien3(string $lien3): void
    {
        $this->lien3 = $lien3;
    }



}