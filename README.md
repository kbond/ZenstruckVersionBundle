# Introduction

Keep track of your Symfony2 project's version.  Knowing what build/version number
a project in staging/production is important.

Many projects have a VERSION or BUILD file created by the developer or CI server.
This bundle provides a block to display on your staging/dev environment.  The
version is available throughout your project as a service.  You can inject the
current version in perhaps a ``meta`` tag for your production environment.

# Installation

1. Add this bundle and php-github-api to your Symfony2 project:

        $ git submodule add git://github.com/kbond/GithubCMSBundle.git vendor/bundles/Zenstruck/VersionBundle

2. Add the ``Zenstruck`` namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
           'Zenstruck' => __DIR__.'/../vendor/bundles',
           // your other namespaces
        ));

# Default Configuration

    # config.yml
    zenstruck_version:
        enabled: false # enable/disable service
        block:
          enabled: false # enable/disable block
          position: vb-bottom-right # other values: vb-bottom-left, vb-top-right, vb-top-left
          prefix: "Version: "

# Usage

Access service in a controller:

    ...
    public function indexAction()
    { 
        $version = $this->get('zenstruck.version.manager')->getVersion();

        ...
    }
    ...

Render a version ``meta`` tag:

    ...

    <meta name="version" content="{% render "zenstruck.version.controller:showAction" %}" />

    ...
