Getting Started With Lockable Command Bundle
============================================

Install
-------
.. code-block:: bash
    composer require loevgaard/lockable-command-bundle

Enable the bundle
-----------------
.. code-block:: php
    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Loevgaard\LockableCommandBundle\LoevgaardLockableCommandBundle(),
            // ...
        );
    }

Implement the LockableCommandInterface
--------------------------------------
.. code-block:: php
    <?php
    namespace AppBundle\Command;

    use Loevgaard\LockableCommandBundle\Command\LockableCommandInterface;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class YourCommand implements LockableCommandInterface
    {
        // ...
    }