<?php 

namespace AppBundle\Exception;

use Exception;
use Symfony\Component\Form\FormInterface;

/**
 * ImportException
 */
class ImportException extends Exception
{
    /**
     * createFromViolationlist static function
     *
     * @param FormInterface $form
     * @param string $name
     * @return \Exception
     */
    public static function createFromForm(FormInterface $form, string $name)
    {
        $errorsMessage = [];
        $errorsMessage[] = $form->getErrors();
        /** @var FormInterface $field */
        foreach ($form->all() as $field) {
            if ($field->getErrors()->count() > 0) {
                $errorsMessage[] = sprintf("el campo '%s' -> %s", strtoupper($field->getName()), $field->getErrors(true, null));
            }
        }

        $message = '';
        if (null !== $name) {
            $message = "$name: ";
        }
        if ($form->getErrors()) {
            $message .= (string)$form->getErrors();
        }

        $message .= implode(', ', $errorsMessage);
        return new self($message);
    }

    /**
     * createFromArray static function
     *
     * @param array $errors
     * @return \Exception
     */
    public static function createFromArray(array $errors)
    {
        $msg = '';
        foreach ($errors as $key => $err) {
            foreach ($err as $k => $e) {
                $msg .= "{$key}: column: {$k}, {$e[0]} ";
            }
        }
        return new self($msg);
    }
}
