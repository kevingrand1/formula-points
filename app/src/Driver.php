<?php

namespace App;


class Driver
{
    private string $driverId;
    private string $firstName;
    private string $lastName;
    private string $code;
    private string $permanentNumber;
    private string $dateOfBirth;
    private string $nationality;

    /**
     * @return string
     */
    public function getDriverId(): string
    {
        return $this->driverId;
    }

    /**
     * @param string $driverId
     * @return Driver
     */
    public function setDriverId(string $driverId): Driver
    {
        $this->driverId = $driverId;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Driver
     */
    public function setFirstName(string $firstName): Driver
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Driver
     */
    public function setLastName(string $lastName): Driver
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Driver
     */
    public function setCode(string $code): Driver
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getPermanentNumber(): string
    {
        return $this->permanentNumber;
    }

    /**
     * @param string $permanentNumber
     * @return Driver
     */
    public function setPermanentNumber(string $permanentNumber): Driver
    {
        $this->permanentNumber = $permanentNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string $dateOfBirth
     * @return Driver
     */
    public function setDateOfBirth(string $dateOfBirth): Driver
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * @return string
     */
    public function getNationality(): string
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     * @return Driver
     */
    public function setNationality(string $nationality): Driver
    {
        $this->nationality = $nationality;
        return $this;
    }

    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getAge()
    {
        return date_diff(date_create($this->getDateOfBirth()), date_create(date("Y-m-d")))->format("%y");
    }

    public function callApi(string $endpoint)
    {
        $curl = curl_init();
        $url = "https://ergast.com/api/f1/{$endpoint}.json";
        curl_setopt_array($curl,[
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 1
        ]);
        $data = curl_exec($curl);
        if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return null;
        }
        return json_decode($data, true);
    }
}
