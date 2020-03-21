<?php


namespace app\behaviors;


use DateTime;
use InvalidArgumentException;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class TimestampTransformBehavior
 * @package behaviors
 *
 * Behaviour works with the specified model attributes and transforms its date value either from unix timestamp or from
 * specified format into MySql Timestamp format.
 * Registered for following events:
 *  ActiveRecord::EVENT_BEFORE_INSERT
 *  ActiveRecord::EVENT_BEFORE_UPDATE
 */
class TimestampTransformBehavior extends Behavior
{
    /**
     * Holds the pairs of model attributes names and its date formats.
     * If the $attributes item is string, then it is model attribute name where the attribute value is unix timestamp.
     * If the $attributes item is array, then the [key] is attribute name and [value] is date format.
     * @var string|array[]
     */
    public $attributes = [];

    private $_attributeFormats = [];

    /**
     * Declares the Event handlers for parent model
     * @return array
     */
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'transform',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'transform'
        ];
    }

    /**
     * Transforms the date from model attribute of each suitable for date() format into MySql Timestamp format.
     *
     */
    public function transform(): void
    {
        $this->_attributeFormats = $this->processProvidedParameters();

        foreach ($this->_attributeFormats as $attributeName => $format) {
            if (!empty($format)) {
                $createdDate = DateTime::createFromFormat($format, $this->owner->$attributeName);
                $this->owner->$attributeName = $createdDate->format('Y-m-d H:i:s');
            } else {
                $this->owner->$attributeName = date('Y-m-d H:i:s', $this->owner->$attributeName);
            }
        }

    }

    /**
     * The function checks if the array contains only one pair of $key => $value.
     * $key represents the name of the model date/time attribute and $value is its format.
     * @param array $arr - the pair of model attribute name [key] and source format [value] in DateTime compatible way.
     * @return null|string
     * @throws InvalidArgumentException
     */
    private function getAttributeName(array $arr): ?string {
        if (count($arr) !== 1) {
            throw new InvalidArgumentException('Date / Time attribute setting must contain only one pair of attribute name and format for each attribute');
        }
        return key($arr);
    }

    /**
     * @param array $arr - the pair of model attribute [key] and source format [value]
     * @param string $key - the key is used to access the value, which is format
     * @return string
     */
    private function getAttributeFormat (array $arr, string $key):string {
        return $arr[$key];
    }

    /**
     * Prepares the attributes for date transform, omits the attributes with empty value
     * Returns array of $key = $attributeName, $value = $format.
     * @return array
     */
    private function processProvidedParameters(): array
    {
        $_attributeFormats = [];
        foreach ($this->attributes as $attribute) {
            if (is_array($attribute)) {
                try {
                    $modelAttribute = $this->getAttributeName($attribute);
                } catch (InvalidArgumentException $exception) {
                    throw $exception;
                }
                $format = $this->getAttributeFormat($attribute, $modelAttribute);
            } else {
                $modelAttribute = $attribute;
                $format ='';
            }
            if (!empty($this->owner->$modelAttribute)) {
                $_attributeFormats[$modelAttribute] = $format;
            }
        }
        return $_attributeFormats;
    }
}