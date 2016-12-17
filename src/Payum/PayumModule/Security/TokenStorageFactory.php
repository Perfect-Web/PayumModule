<?php
namespace Payum\PayumModule\Security;

use Payum\PayumModule\Options\PayumOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;

class TokenStorageFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createService($container);
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var PayumOptions $options */
        $options = $serviceLocator->get('payum.options');

        return is_object($options->getTokenStorage()) ?
            $options->getTokenStorage() :
            $serviceLocator->get($options->getTokenStorage())
        ;
    }
}