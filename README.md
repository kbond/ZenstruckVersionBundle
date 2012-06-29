# Introduction

Keep track of your Symfony2 application's version.  Knowing what build/version number
an application in staging/production is important.

Many projects have a VERSION or BUILD file created by the developer or CI server.
This bundle provides a block, twig function, and web debug toolbar panel to output
both the application's and Symfony's version.  The version is available throughout
your project as a service.  You can inject the current version in perhaps a ``meta``
tag for your production environment.

# Installation

1. Install the bundle through composer :

``` javascript
{
    "require": {
        // ...
        "zenstruck/version-bundle": "dev-master"
    }
}
```

2. Create a ``VERSION`` file in your project's root directory

3. Configure the bundle:

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

# Usage

When enabled, this plugin defines two twig functions:

* ``version()``: outputs the current application version (as defined in your ``VERSION`` file)
* ``symfony()``: outputs the current Symfony version (as defined in ``Symfony\Component\HttpKernel\Kernel::VERSION``)

And adds a service to Symfony's service container:

* ``zenstruck.version.data_collector``

# Examples

Access service in a controller:

    ...
    public function indexAction()
    {
        $versionDC = $this->get('zenstruck.version.data_collector');

        $appVersion = $versionDC->getVersion();
        $symfonyVersion = $versionDC->getSymfony();
        ...
    }
    ...

Render in template:

    {# twig template #}
    {{ version() }}
    {{ symfony() }}

Render a ``meta`` tag with application version and Symfony version:

    ...
    <meta name="version" content="{{ version() }}" />
    <meta name="symfony" content="{{ symfony() }}" />
    ...


# Extend

## Use your own Version DataCollector

1. Overrride the default ``VersionDataCollector`` class:

        // MyVersion.php
        use Zenstruck\Bundle\VersionBundle\DataCollector\VersionDataCollector;

        class MyVersion extends VersionDataCollector
        {
            public function getVersion()
            {
                return $myversion;
            }
        }

2. Set you ``VersionDataCollector`` class in ``app/config.yml``:

        // app/config.yml
        parameters:
            zenstruck.version.data_collector.class: \MyVersion

# Full Default Configuration

    # config.yml
    zenstruck_version:
        enabled: false                      # enable/disable service
        toolbar: false                      # show in web debug toolbar
        file: %kernel.root_dir%/../VERSION  # the file containing version info
        suffix: ~                           # suffix text (ie "-dev")
        version: ~                          # overrides file/text with custom version
        block:
          enabled: false                    # enable/disable block
          position: vb-bottom-right         # other values: vb-bottom-left, vb-top-right, vb-top-left
          prefix: "Version: "               # text added to beginning of block