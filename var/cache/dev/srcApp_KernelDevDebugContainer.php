<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerExxuA06\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerExxuA06/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerExxuA06.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerExxuA06\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerExxuA06\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'ExxuA06',
    'container.build_id' => 'f9cb77f6',
    'container.build_time' => 1574811742,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerExxuA06');