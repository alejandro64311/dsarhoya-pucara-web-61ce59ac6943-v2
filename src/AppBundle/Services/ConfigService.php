<?php

namespace AppBundle\Services;

/**
 * Config Service.
 *
 * Servicio de utilidad para ahorrarnos la injecciñon de dependencias por parametros
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ConfigService
{
    /**
     * @var string
     */
    private $s3Region;

    /**
     * @var string
     */
    private $s3Bucket;

    /**
     * @var string
     */
    private $s3Key;

    /**
     * @var string
     */
    private $s3Secret;

    /**
     * @var string
     */
    private $companyName;

    /**
     * @var string
     */
    private $serviceName;

    /**
     * @var string
     */
    private $weatherApiKey;

    public $env;
    public $stageMine;

    /**
     * Constructor.
     */
    public function __construct(
        $companyName,
        $serviceName,
        $s3Key,
        $s3Secret,
        $s3Bucket,
        $s3Region,
        $weatherApiKey,
        $env,
        $stageMine
    ) {
        $this->companyName = $companyName;
        $this->serviceName = $serviceName;
        $this->s3Key = $s3Key;
        $this->s3Secret = $s3Secret;
        $this->s3Bucket = $s3Bucket;
        $this->s3Region = $s3Region;
        $this->weatherApiKey = $weatherApiKey;
        $this->env = $env;
        $this->stageMine = $stageMine;
    }

    /**
     * getCompanyName function.
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * getServiceName function.
     */
    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    /**
     * Get AWS S3 Region.
     */
    public function getS3Region(): ?string
    {
        return $this->s3Region;
    }

    /**
     * Get AWS S3 Bucket.
     */
    public function getS3Bucket(): ?string
    {
        return $this->s3Bucket;
    }

    /**
     * Get AWS S3 Key.
     */
    public function getS3Key(): ?string
    {
        return $this->s3Key;
    }

    /**
     * Get AWS S3 Secret.
     */
    public function getS3Secret(): ?string
    {
        return $this->s3Secret;
    }

    /**
     * Get Weather API Key.
     */
    public function getWeatherApiKey(): ?string
    {
        return $this->weatherApiKey;
    }
}
