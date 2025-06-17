<?php

namespace Pekhota\NovaHugeRTE;

use Laravel\Nova\Fields\Expandable;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;

class HugeRTE extends Field
{
    use SupportsDependentFields;
    use Expandable;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-hugerte';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function __construct(string $name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute);
        $this->resolveCallback = $resolveCallback;

        $this->withMeta([
            'options' => config('nova-hugerte', []),
        ]);
    }

    public function options($options)
    {
        $inlineOptions = $this->meta['options'] ?? [];

        return $this->withMeta([
            'options' => array_merge($inlineOptions, $options),
        ]);
    }

    /**
     * Prepare the element for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'shouldShow' => $this->shouldBeExpanded(),
        ]);
    }
}
