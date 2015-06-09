<?php
namespace FDevs\ContactList\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnectType extends AbstractType
{
    /** @var array */
    private $types = [
        'linkedin'    => 'LinkedIn',
        'envelope'    => 'Envelope',
        'github'      => 'Github',
        'skype'       => 'Skype',
        'vk'          => 'vk',
        'facebook'    => 'facebook',
        'twitter'     => 'twitter',
        'youtube'     => 'youtube',
        'dropbox'     => 'dropbox',
        'instagram'   => 'instagram',
        'flickr'      => 'flickr',
        'bitbucket'   => 'bitbucket',
        'foursquare'  => 'foursquare',
        'trello'      => 'trello',
        'wordpress'   => 'wordpress',
        'database'    => 'database',
        'vimeo'       => 'vimeo',
        'openid'      => 'openid',
        'yahoo'       => 'yahoo',
        'google'      => 'google',
        'digg'        => 'digg',
        'fax'         => 'fax',
        'home'        => 'home',
        'git'         => 'git',
        'wechat'      => 'wechat',
        'link'        => 'link',
        'certificate' => 'certificate',
        'rss'         => 'rss',
        'phone'       => 'phone',
    ];

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', ['choices' => $options['types'], 'label' => 'Connect Type'])
            ->add('text', 'text', ['label' => 'Connect Text'])
            ->add('link', 'text', ['label' => 'Connect Link']);
    }

    /**
     * set Types
     *
     * @param array $types
     *
     * @return $this
     */
    public function setTypes(array $types = [])
    {
        $this->types = $types;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined(['types'])
            ->setDefaults(
                [
                    'types'      => $this->types,
                    'data_class' => 'FDevs\ContactList\Model\Connect',
                    'translation_domain' => 'FDevsContactList',
                ]
            )
            ->addAllowedTypes('types', 'array');
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'connect';
    }
}
