# Introduction

Keep track of your Symfony2 project's version.  Knowing what build/version number
a project in staging/production is important.

Many projects have a VERSION or BUILD file created by the developer or CI server.
This bundle provides a block to display on your staging/dev environment.  The
version is available throughout your project as a service.  You can inject the
current version in perhaps a ``meta`` tag for your production environment.

# Installation

1. Add this bundle and php-github-api to your Symfony2 project:

        $ git submodule add git://github.com/kbond/VersionBundle.git vendor/bundles/Zenstruck/VersionBundle

2. Add the ``Zenstruck`` namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
           'Zenstruck' => __DIR__.'/../vendor/bundles',
           // your other namespaces
        ));

3. Add this bundle to your application's kernel:

        // app/AppKernel.php
         public function registerBundles()
         {
             return array(
                 // ...
                 new Zenstruck\VersionBundle\VersionBundle(),
                 // ...
             );
         }

4. Create a ``VERSION`` file in your project's root directory

5. Add configuration

        # Example
        # app/config_dev.yml
        zenstruck_version:
            enabled: true
            toolbar: true

        #app/config_staging.yml
        zenstruck_version:
            enabled: true
            toolbar: false
            block:
                enabled: true


# Default Configuration

    # config.yml
    zenstruck_version:
        enabled: false                      # enable/disable service
        toolbar: false                      # show in web debug toolbar
        file: %kernel.root_dir%/../VERSION  # the file containing version info
        block:
          enabled: false                    # enable/disable block
          position: vb-bottom-right         # other values: vb-bottom-left, vb-top-right, vb-top-left
          prefix: "Version: "               # text added to beginning of block

# Usage

Access service in a controller:

    ...
    public function indexAction()
    { 
        $version = $this->get('zenstruck.version.data_collector')->getVersion();
        ...
    }
    ...

Render in template - uses twig function ``version()``:

    {# twig template #}
    {{ version() }}

**Example** Render a ``meta`` tag with version:

    ...
    <meta name="version" content="{{ version() }}" />
    ...
