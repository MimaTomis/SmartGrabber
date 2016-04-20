<?php
namespace SmartGrabber\Visitor;

use SmartGrabber\Element\FileElement;
use SmartGrabber\Element\StringElement;
use SmartGrabber\Exception\LogicException;

class BaseElementVisitor implements ElementVisitorInterface
{
    /**
     * Visit file element.
     *
     * @param FileElement $element
     */
    public function visitFile(FileElement $element)
    {
        $file = $element->getContent();
        $content = file_get_contents($file);

        if ($content === false)
            throw new LogicException(sprintf('%s is not readable file', $file));

        $tempFile = tempnam(sys_get_temp_dir(), 'SP');
        file_put_contents($tempFile, $content);

        $element->setPath($tempFile);
        $element->setContent($tempFile);
    }

    /**
     * Visit string element
     *
     * @param StringElement $element
     */
    public function visitString(StringElement $element)
    {

    }
}