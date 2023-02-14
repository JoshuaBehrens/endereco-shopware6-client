<?php

declare(strict_types=1);

namespace Endereco\Shopware6Client\Test\Subscriber;

use Endereco\Shopware6Client\Entity\EnderecoAddressExtension\EnderecoAddressExtensionEntity;
use Endereco\Shopware6Client\Service\EnderecoService;
use Endereco\Shopware6Client\Subscriber\CheckoutSubscriber;
use Endereco\Shopware6Client\Test\ConfigTrait;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Checkout\Customer\Aggregate\CustomerAddress\CustomerAddressEntity;
use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\System\Country\CountryEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\Checkout\Confirm\CheckoutConfirmPageLoadedEvent;

class CheckoutSubscriberTest extends TestCase
{
    use ConfigTrait;

    public function testIfCheckoutSubscriberWillSplitAddressesOnEmptyEnderecoAddress()
    {
        $enderecoServiceMock = $this->createMock(EnderecoService::class);
        $checkoutSubscriber = new CheckoutSubscriber(
            $this->getSystemConfigService(),
            $enderecoServiceMock,
            $this->createMock(EntityRepository::class),
            $this->createMock(EntityRepository::class),
            $this->createMock(EntityRepository::class)
        );

        $event = $this->createConfiguredMock(CheckoutConfirmPageLoadedEvent::class, [
            'getSalesChannelContext' => $this->createConfiguredMock(SalesChannelContext::class, [
                'getContext' => $this->createMock(Context::class),
                'getCustomer' => $this->createConfiguredMock(CustomerEntity::class, [
                        'getActiveShippingAddress' => $this->createConfiguredMock(CustomerAddressEntity::class, [
                            'getCountry' => $this->createConfiguredMock(CountryEntity::class, [
                                'getIso' => 'DE'
                            ])
                        ]),
                        'getActiveBillingAddress' => $this->createConfiguredMock(CustomerAddressEntity::class, [
                            'getCountry' => $this->createConfiguredMock(CountryEntity::class, [
                                'getIso' => 'DE'
                            ])
                        ]),
                    ])
            ])
        ]);

        $enderecoServiceMock
            ->expects($this->atLeast(2))
            ->method('splitStreet')
            ->willReturn(['Test', '44']);

        $checkoutSubscriber->ensureAddressesAreSplit($event);
    }

    public function testIfCheckoutSubscriberWillSplitAddressesWhenEnderecoAddressHasDifferentSavedData()
    {
        $enderecoServiceMock = $this->createMock(EnderecoService::class);
        $checkoutSubscriber = new CheckoutSubscriber(
            $this->getSystemConfigService(),
            $enderecoServiceMock,
            $this->createMock(EntityRepository::class),
            $this->createMock(EntityRepository::class),
            $this->createMock(EntityRepository::class)
        );

        $event = $this->createConfiguredMock(CheckoutConfirmPageLoadedEvent::class, [
            'getSalesChannelContext' => $this->createConfiguredMock(SalesChannelContext::class, [
                'getContext' => $this->createMock(Context::class),
                'getCustomer' => $this->createConfiguredMock(CustomerEntity::class, [
                        'getActiveShippingAddress' => $this->createConfiguredMock(CustomerAddressEntity::class, [
                            'getCountry' => $this->createConfiguredMock(CountryEntity::class, [
                                'getIso' => 'DE'
                            ]),
                            'getStreet' => 'Testing 55',
                            'getExtension' => $this->createConfiguredMock(EnderecoAddressExtensionEntity::class, [
                                'getStreet' => 'Testing',
                                'getHouseNumber' => '33'
                            ])
                        ]),
                        'getActiveBillingAddress' => null
                    ])
            ])
        ]);

        $enderecoServiceMock
            ->expects($this->atLeast(1))
            ->method('splitStreet')
            ->willReturn(['Test', '55']);

        $checkoutSubscriber->ensureAddressesAreSplit($event);
    }

    public function testIfCheckoutSubscriberWillNotSplitAddressesWhenEnderecoAddressIsSame()
    {
        $enderecoServiceMock = $this->createConfiguredMock(EnderecoService::class, [
            'buildFullStreet' => 'Testing 55'
        ]);
        $checkoutSubscriber = new CheckoutSubscriber(
            $this->getSystemConfigService(),
            $enderecoServiceMock,
            $this->createMock(EntityRepository::class),
            $this->createMock(EntityRepository::class),
            $this->createMock(EntityRepository::class)
        );

        $event = $this->createConfiguredMock(CheckoutConfirmPageLoadedEvent::class, [
            'getSalesChannelContext' => $this->createConfiguredMock(SalesChannelContext::class, [
                'getContext' => $this->createMock(Context::class),
                'getCustomer' => $this->createConfiguredMock(CustomerEntity::class, [
                        'getActiveShippingAddress' => $this->createConfiguredMock(CustomerAddressEntity::class, [
                            'getCountry' => $this->createConfiguredMock(CountryEntity::class, [
                                'getIso' => 'DE'
                            ]),
                            'getStreet' => 'Testing 55',
                            'getExtension' => $this->createConfiguredMock(EnderecoAddressExtensionEntity::class, [
                                'getStreet' => 'Testing',
                                'getHouseNumber' => '55'
                            ])
                        ]),
                        'getActiveBillingAddress' => null
                    ])
            ])
        ]);

        $enderecoServiceMock
            ->expects($this->never())
            ->method('splitStreet');

        $checkoutSubscriber->ensureAddressesAreSplit($event);
    }
}
