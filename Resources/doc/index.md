Getting Started With Contact List Library
=========================================

## Installation and usage

Installation and usage is a quick:

1. Download Contact List library using composer
2. Use the library
3. Usage with symfony [form](http://symfony.com/doc/current/components/form/introduction.html)
4. Usage with [twig](http://twig.sensiolabs.org/)  


### Step 1: Download Contact List library using composer

Add Contact List Library in your composer.json:

```js
{
    "require": {
        "fdevs/contact-list": "*"
    }
}
```

Now tell composer to download the library by running the command:

``` bash
$ php composer.phar update fdevs/contact-list
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Base usage the library

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use FDevs\ContactList\ContactFactory;
use FDevs\ContactList\Renderer\OrganizationRenderer;
use FDevs\Locale\Translator;

$factory = new ContactFactory();
$contact = $factory->createContact('footer');
$factory->addAddress($contact, 'Россия', 'Москва', 'Москва', '', '103132', 'ул. Ильинка, д. 23', 'ru');
$factory->addAddress($contact, 'Russia', 'Moscow', 'Moscow', '', '103132', 'st. Ilinka Str. 23', 'en');

$render = new OrganizationRenderer(new Translator('ru'));

echo $render->renderContact($contact);
//<div itemscope itemtype="http://schema.org/Organization"><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress">ул. Ильинка, д. 23</span><span itemprop="postalCode">103132</span><span itemprop="addressLocality">Москва</span><span itemprop="addressCountry">Россия</span></div></div>

//add connect
$factory->addConnect($contact, 'skype', 'andrey', 'skype:andrey');

echo $render->renderContact($contact);
//<div itemscope itemtype="http://schema.org/Organization"><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"> <span itemprop="streetAddress">ул. Ильинка, д. 23</span> <span itemprop="postalCode">103132</span> <span itemprop="addressRegion">Москва</span> <span itemprop="addressLocality">Москва</span> <span itemprop="addressCountry">Россия</span></div><ul><li><a href="skype:andrey" title="andrey"><i class="fa fa-skype"></i>andrey</a></li></ul></div>

//change locale address
echo $render->renderContact($contact, ['locale' => 'en']);
//<div itemscope itemtype="http://schema.org/Organization"><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"> <span itemprop="streetAddress">st. Ilinka Str. 23</span> <span itemprop="postalCode">103132</span> <span itemprop="addressRegion">Moscow</span> <span itemprop="addressLocality">Moscow</span> <span itemprop="addressCountry">Russia</span></div><ul><li><a href="skype:andrey" title="andrey"><i class="fa fa-skype"></i>andrey</a></li></ul></div>

//show contact list
$otherContact = $factory->createContact('new');
$factory->addAddress($otherContact, 'Россия', 'Республика Крым', 'Симферополь', '', '95000', 'пер. Совнаркомовский, 3а', 'ru');

echo $render->renderList([$contact, $otherContact]);
//<div itemscope itemtype="http://schema.org/Organization"><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"> <span itemprop="streetAddress">ул. Ильинка, д. 23</span> <span itemprop="postalCode">103132</span> <span itemprop="addressRegion">Москва</span> <span itemprop="addressLocality">Москва</span> <span itemprop="addressCountry">Россия</span></div><ul><li><a href="skype:andrey" title="andrey"><i class="fa fa-skype"></i>andrey</a></li></ul></div><div itemscope itemtype="http://schema.org/Organization"><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"> <span itemprop="streetAddress">пер. Совнаркомовский, 3а</span> <span itemprop="postalCode">95000</span> <span itemprop="addressRegion">Симферополь</span> <span itemprop="addressLocality">Республика Крым</span> <span itemprop="addressCountry">Россия</span></div></div>

```

### Step 3: Usage with symfony form

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Form\Forms;
use FDevs\ContactList\Form\Type\AddressType;
use FDevs\ContactList\Form\Type\ConnectType;
use FDevs\ContactList\Form\Type\ContactType;
use FDevs\Locale\Form\Type\TransType;
use FDevs\Locale\Form\Type\TransTextType;
use FDevs\Locale\Form\Type\LocaleType;
use FDevs\Locale\Form\Type\LocaleTextType;
use FDevs\Geo\Form\Type\PointType;
use FDevs\Geo\Form\Type\CoordinatesType;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;


// the Twig file that holds all the default markup for rendering forms
// this file comes with TwigBridge

// the path to TwigBridge so Twig can locate the
// form_div_layout.html.twig file
$defaultFormTheme = 'form_div_layout.html.twig';
$ref = new ReflectionClass('Symfony\Bridge\Twig\TwigEngine');
$vendorTwigBridgeDir = dirname($ref->getFileName());

// the path to your other templates
$twig = new \Twig_Environment(new \Twig_Loader_Filesystem([$vendorTwigBridgeDir.'/Resources/views/Form']));

$formEngine = new TwigRendererEngine([$defaultFormTheme]);
$formEngine->setEnvironment($twig);
// add the FormExtension to Twig
$twig->addExtension(new FormExtension(new TwigRenderer($formEngine)));
$twig->addExtension(new TranslationExtension(new Translator('en')));
$transForm = new TransType();
$transForm->setLocales(['en', 'ru']);
$formFactory = Forms::createFormFactoryBuilder()
 ->addExtension(new ValidatorExtension(Validation::createValidator()))
 ->addTypes([
//add geo form
     new CoordinatesType(),
     new PointType(),

//add locale form
     new LocaleType(),
     new LocaleTextType(),
     $transForm,
     new TransTextType(),

//use contact form
     new ContactType(),
     new ConnectType(),
     new AddressType(),
 ])
 ->getFormFactory();


$form = $formFactory->createBuilder()
 ->add('contact', 'contact')
 ->add('text', 'text')
 ->getForm();

echo $twig->createTemplate('{{form(form)}}')->render(['form' => $form->createView()]);

```

### Step 4: Usage with twig

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use FDevs\ContactList\ContactFactory;
use FDevs\ContactList\Twig\ContactExtension;
use FDevs\ContactList\Twig\Helper;
use FDevs\ContactList\Renderer\TwigRenderer;
use FDevs\ContactList\Provider\MemoryProvider;
use FDevs\Locale\Twig\TranslatorExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;
use FDevs\Locale\Model\LocaleText;
use FDevs\Locale\Translator as LocaleTranslator;

$ref = new \ReflectionClass('FDevs\ContactList\ContactFactory');
$vendorTwigBridgeDir = dirname($ref->getFileName());

$translator = new LocaleTranslator('ru');
$twig = new \Twig_Environment(new \Twig_Loader_Filesystem([$vendorTwigBridgeDir.'/Resources/views']));
$twig->addExtension(new TranslatorExtension([], $translator));
$twig->addExtension(new TranslationExtension(new Translator('en')));

$factory = new ContactFactory();
$contact = $factory->createContact('footer');
$factory->addAddress($contact, 'Россия', 'Москва', 'Москва', '', '103132', 'ул. Ильинка, д. 23', 'ru');
$factory->addAddress($contact, 'Russia', 'Moscow', 'Moscow', '', '103132', 'st. Ilinka Str. 23', 'en');

$provider = new MemoryProvider([$contact]);
$helper = new Helper(new TwigRenderer($twig, $translator), $provider);
$twig->addExtension(new ContactExtension($helper));

echo "\n";
echo $twig->createTemplate('{{contact("footer")}}')->render([]);
//<div itemscope itemtype="http://schema.org/Organization"><span>Address:</span><div itemprop="address" class="postal-address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress" class="postal-address__street">ул. Ильинка, д. 23</span><span itemprop="postalCode" class="postal-address__code">103132</span><span itemprop="addressRegion" class="postal-address__region">Москва</span><span itemprop="addressCountry" class="postal-address__country">Россия</span></div><ul class="list-inline social-buttons"></ul></div>

echo "\n";
echo $twig->createTemplate('{{contact("footer","","en")}}')->render([]);
//<div itemscope itemtype="http://schema.org/Organization"><span>Address:</span><div itemprop="address" class="postal-address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress" class="postal-address__street">st. Ilinka Str. 23</span><span itemprop="postalCode" class="postal-address__code">103132</span><span itemprop="addressRegion" class="postal-address__region">Moscow</span><span itemprop="addressCountry" class="postal-address__country">Russia</span></div><ul class="list-inline social-buttons"></ul></div>

echo "\n";
$contact->addName(new LocaleText('contact name', 'ru'));
echo $twig->createTemplate('{{contact("footer")}}')->render([]);
//<div itemscope itemtype="http://schema.org/Organization"><span itemprop="name">contact name</span><span>Address:</span><div itemprop="address" class="postal-address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress" class="postal-address__street">ул. Ильинка, д. 23</span><span itemprop="postalCode" class="postal-address__code">103132</span><span itemprop="addressRegion" class="postal-address__region">Москва</span><span itemprop="addressCountry" class="postal-address__country">Россия</span></div><ul class="list-inline social-buttons"></ul></div>

//add connect
$factory->addConnect($contact, 'skype', 'andrey', 'andrey');
$factory->addConnect($contact, 'email', 'andrey', 'andrey@4devs.org');
$factory->addConnect($contact, 'phone', 'Телефон', '88002002316');
$factory->addConnect($contact, 'fax', '+7(095)206-07-66', '+70952060766');
$factory->addConnect($contact, 'github', '4devs', 'https://github.com/4devs');

echo "\n";
echo $twig->createTemplate('{{contact("footer")}}')->render([]);
//<div itemscope itemtype="http://schema.org/Organization"><span>Address:</span><div itemprop="address" class="postal-address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress" class="postal-address__street">ул. Ильинка, д. 23</span><span itemprop="postalCode" class="postal-address__code">103132</span><span itemprop="addressRegion" class="postal-address__region">Москва</span><span itemprop="addressCountry" class="postal-address__country">Россия</span></div><ul class="list-inline social-buttons"><li itemprop="skype" class="connect connect_skype"><a href="skype:andrey" title="andrey"><i class="fa fa-skype"></i>andrey</a></li><li itemprop="email" class="connect connect_email"><a href="mailto:andrey@4devs.org" title="andrey"><i class="fa fa-email"></i>andrey@4devs.org</a></li><li itemprop="telephone" class="connect connect_phone"><a href="tel:88002002316" title="Телефон"><i class="fa fa-phone"></i>88002002316</a></li><li itemprop="faxNumber" class="connect connect_fax-number"><a href="tel:+70952060766" title="+7(095)206-07-66"><i class="fa fa-fax"></i>+70952060766</a></li><li class="connect connect_github"><a href="https://github.com/4devs" title="4devs"><i class="fa fa-github"></i>4devs</a></li></ul></div>

```

#### template blocks priority

* contact block name by priority
** `{prefix}_contact`
** `{slug}_contact`
** `fdevs_contact`

* address block name by priority
** `{prefix}_{locale}_address`
** `{prefix}_address`
** `{locale}_address`
** `fdevs_{locale}_address`
** `fdevs_address`

* connect block name by priority
** `{prefix}_{type}_connect`
** `{type}_connect`
** `{contact_prefix|slug}_{type}_connect` - if use as contact  
** `{contact_prefix|slug}_connect` - if use as contact  
** `fdevs_connect`

#### customize render

create new template

```twig
{# views/your_best_contact.html.twig #}

{% extends 'fdevs_contact.html.twig' %}
{% block fdevs_address %}
{% spaceless %}
    <ul itemprop="address" class="postal-address" itemscope itemtype="http://schema.org/PostalAddress">
        {% if address.street %}
            <li itemprop="streetAddress" class="postal-address__street">{{ address.street }}</li>
        {% endif %}
        {% if address.code %}
            <li itemprop="postalCode" class="postal-address__code">{{ address.code }}</li>
        {% endif %}
        {% if address.box %}
            <li itemprop="postOfficeBoxNumber" class="postal-address__box">{{ address.box }}</li>
        {% endif %}
        {% if address.region %}
            <li itemprop="addressRegion" class="postal-address__region">{{ address.region }}</li>
        {% endif %}
        {% if locality %}
            <li itemprop="addressLocality" class="postal-address__locality">{{ address.locality }}</li>
        {% endif %}
        {% if address.country %}
            <li itemprop="addressCountry" class="postal-address__country">{{ address.country }}</li>
        {% endif %}
    </ul>
{% endspaceless %}
{% endblock fdevs_address %}

```

add template to renderer

```php
$provider = new MemoryProvider([$contact]);
$helper = new Helper(new TwigRenderer($twig, 'ru', 'views/your_best_contact.html.twig'), $provider);
$twig->addExtension(new ContactExtension($helper));
```