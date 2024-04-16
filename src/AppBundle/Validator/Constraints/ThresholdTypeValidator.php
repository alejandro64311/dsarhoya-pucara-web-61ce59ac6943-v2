<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\RisksControls;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ThresholdTypeValidator extends ConstraintValidator
{
    public function validate($entity, Constraint $constraint)
    {
        if (!$constraint instanceof ThresholdType) {
            throw new UnexpectedTypeException($constraint, ThresholdType::class);
        }

        if (!$entity instanceof RisksControls) {
            throw new UnexpectedTypeException($constraint, RisksControls::class);
        }

        // dump($entity->getType(), $entity->getThreshold());
        // die;

        if (RisksControls::SOIL_FREEZING !== $entity->getType() && !is_numeric($entity->getThreshold())) {
            // dump('NO suelos congelados');
            // die;
            $this->context->buildViolation('Limit "{{ string }}" no válido para este tipo. Solo valores númericos.')
                ->setParameter('{{ string }}', $entity->getThreshold())
                ->atPath('threshold')
                ->addViolation();
        }

        if (RisksControls::SOIL_FREEZING === $entity->getType() && !in_array($entity->getThreshold(), [RisksControls::SOIL_FREEZING_YES_LABEL, RisksControls::SOIL_FREEZING_NO_LABEL])) {
            // dump('NO suelos congelados');
            // die;
            $this->context->buildViolation('El valor "{{ string }}" no válido para este tipo. Valores aceptados son "'.RisksControls::SOIL_FREEZING_YES_LABEL.'", "'.RisksControls::SOIL_FREEZING_NO_LABEL.'" (EN MAYUSCULAS).')
                ->setParameter('{{ string }}', $entity->getThreshold())
                ->atPath('threshold')
                ->addViolation();
        }
    }
}
