# Cuckoo
_A PhalconPHP HMVC skeleton_

This project skeleton is based on the [PhalconPHP HMVC skeleton](https://github.com/zekiunal/PhalconHMVCSkeletonApplication) built by
[Zeki ÜNAL](https://github.com/zekiunal) with some modifications.

The skeleton is meant as a foundation for projects that will use PhalconPHP with the HMVC pattern. The project is in its very
first stages of development, but it does currently work out of the box. There are several things that should be addressed, such as
making the ACL implementation more dynamic, if you should decide to use this for live projcets.

I will make further updates here soon, with usage and development examples.

## Differences

_Some of the things that makes it different from Zeki's skeleton?_

* Cuckoo will automatically detect new modules and register them with the application.
* Routes has also been moved into the respective module folder. This means that they will be registered together with the module.
* Registration of ACL resources and actions has been moved into the module's bootstraper instead of through a module plugins.

## Future plans

* Create adapters for ACL roles generation. Currently it only supports roles set in config.php

... I add more to this document later