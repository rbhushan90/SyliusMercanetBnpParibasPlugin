<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\MercanetBnpParibasPlugin\Bridge;

use BitBag\MercanetBnpParibasPlugin\Legacy\Mercanet;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class MercanetBnpParibasBridge implements MercanetBnpParibasBridgeInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $keyVersion;

    /**
     * @var string
     */
    private $environment;

    /** @var Mercanet */
    private $mercanet;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritDoc}
     */
    public function createMercanet($secretKey)
    {
        return new Mercanet($secretKey);
    }

    /**
     * {@inheritDoc}
     */
    public function paymentVerification()
    {
        if ($this->isPostMethod()) {

            $this->mercanet = new Mercanet($this->secretKey);
            $this->mercanet->setResponse($_POST);

            return $this->mercanet->isValid();
        }

        return false;
    }

    public function getAuthorisationId()
    {
        return $this->mercanet->getAuthorisationId();
    }

    /**
     * {@inheritDoc}
     */
    public function isPostMethod()
    {
        $currentRequest = $this->requestStack->getCurrentRequest();

        return $currentRequest->isMethod('POST');
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public function getKeyVersion()
    {
        return $this->keyVersion;
    }

    /**
     * @param string $keyVersion
     */
    public function setKeyVersion($keyVersion)
    {
        $this->keyVersion = $keyVersion;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }
}
