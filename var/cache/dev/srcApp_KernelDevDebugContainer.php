<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerXCukbwV\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerXCukbwV/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerXCukbwV.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerXCukbwV\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerXCukbwV\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'XCukbwV',
    'container.build_id' => 'ea21dfc2',
    'container.build_time' => 1581187575,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerXCukbwV');
