<?php
namespace common\components;


class Html extends \yii\helpers\Html
{

    /**
     * @param string $text
     * @param string $class
     * @param string|null $toolTipText
     * @param string $toolTipPlacement
     * @return string
     */
    public static function badge(string $text, string $class, string $toolTipText = null, string $toolTipPlacement = 'right'): string
    {
        $toolTip = null;
        if (isset($toolTipText)) {
            $toolTip = "data-bs-toggle='tooltip' data-bs-placement='" . $toolTipPlacement . "' data-bs-title='{$toolTipText}'";
        }

        return "<span class='{$class}' {$toolTip}>{$text}</span>";
    }
}
