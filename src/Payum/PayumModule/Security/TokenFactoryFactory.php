<?php
namespace Payum\PayumModule\Security;

use Payum\Core\Security\GenericTokenFactory;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;

class TokenFactoryFactory implements FactoryInterface
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
        /** @var PluginManager $plugins */
        $plugins = $serviceLocator->get('ControllerPluginManager');

        $tokenFactory = new TokenFactory(
            $serviceLocator->get('payum.security.token_storage'),
            $serviceLocator->get('payum')
        );
        $tokenFactory->setUrlPlugin($plugins->get('url'));

        return new GenericTokenFactory($tokenFactory, array(
            'capture' => 'payum_capture_do',
            'notify' => 'payum_notify_do',
            'authorize' => 'payum_authorize_do',
            'refund' => 'payum_refund_do'
        ));
    }
}