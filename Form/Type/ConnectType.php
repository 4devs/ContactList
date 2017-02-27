<?php

namespace FDevs\ContactList\Form\Type;

use FDevs\ContactList\Model\Connect;
use function MongoDB\read_concern_as_document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnectType extends AbstractType
{
    /** @var array */
    private $types = [
        'linkedin' => 'LinkedIn',
        'envelope' => 'Envelope',
        'github' => 'Github',
        'skype' => 'Skype',
        'vk' => 'vk',
        'facebook' => 'facebook',
        'twitter' => 'twitter',
        'youtube' => 'youtube',
        'dropbox' => 'dropbox',
        'instagram' => 'instagram',
        'flickr' => 'flickr',
        'bitbucket' => 'bitbucket',
        'foursquare' => 'foursquare',
        'trello' => 'trello',
        'wordpress' => 'wordpress',
        'database' => 'database',
        'vimeo' => 'vimeo',
        'openid' => 'openid',
        'yahoo' => 'yahoo',
        'google' => 'google',
        'digg' => 'digg',
        'fax' => 'fax',
        'home' => 'home',
        'git' => 'git',
        'wechat' => 'wechat',
        'link' => 'link',
        'certificate' => 'certificate',
        'rss' => 'rss',
        'phone' => 'phone',
    ];

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => $options['types'],
                'choices_as_values' => true,
                'label' => 'Connect Type',
                'choice_label' => function ($val) {
                    return ucfirst($val);
                },
                'choice_value' => function ($val) {
                    return strtolower($val);
                }
            ])
            ->add('text', TextType::class, ['label' => 'Connect Text'])
            ->add('link', TextType::class, ['label' => 'Connect Link']);
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
            ->setDefaults([
                'types' => $this->types,
                'data_class' => Connect::class,
                'translation_domain' => 'FDevsContactList',
            ])
            ->addAllowedTypes('types', 'array');
    }
}
