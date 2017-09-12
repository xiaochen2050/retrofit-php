<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Tebru\Retrofit\Internal\AnnotationHandler;

use Tebru\AnnotationReader\AbstractAnnotation;
use Tebru\Retrofit\Annotation\Field;
use Tebru\Retrofit\AnnotationHandler;
use Tebru\Retrofit\Converter;
use Tebru\Retrofit\Internal\ParameterHandler\FieldParamHandler;
use Tebru\Retrofit\ServiceMethodBuilder;
use Tebru\Retrofit\StringConverter;

/**
 * Class FieldAnnotHandler
 *
 * @author Nate Brunette <n@tebru.net>
 */
final class FieldAnnotHandler implements AnnotationHandler
{
    /**
     * Set the content type to form encoded and adds a parameter handler for individual fields
     *
     * @param Field|AbstractAnnotation $annotation The annotation to handle
     * @param ServiceMethodBuilder $serviceMethodBuilder Used to construct a [@see ServiceMethod]
     * @param Converter|StringConverter $converter Converter used to convert types before sending to service method
     * @param int|null $index The position of the parameter or null if annotation does not reference parameter
     * @return void
     */
    public function handle(
        AbstractAnnotation $annotation,
        ServiceMethodBuilder $serviceMethodBuilder,
        ?Converter $converter,
        ?int $index
    ): void {
        $serviceMethodBuilder->setIsFormUrlEncoded();
        $serviceMethodBuilder->addParameterHandler(
            $index,
            new FieldParamHandler($converter, $annotation->getValue(), $annotation->isEncoded())
        );
    }
}