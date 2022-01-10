<?php

namespace Stepanorda\NovaQuill;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaQuill extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-quill';

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = is_string($request[$requestAttribute]) ? json_decode($request[$requestAttribute]) : $request[$requestAttribute];
        }
    }
}
