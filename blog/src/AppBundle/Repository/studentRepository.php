<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class studentRepository extends EntityRepository
{
     public function findAllOrderByName()
    {
        return $this->findBy(array(),array('name' =>'ASC'));
     }
     public function  newAction(\AppBundle\Entity\Studentdetails $stud)
     {
         $this->_em->persist($stud);
         $this->_em->flush();
     }
     public function deleteAction(\AppBundle\Entity\studentdetails $stud)
     {
         if (!$stud) {
             throw $this->createNotFoundException('No student found for id '.$id);
         }
         $this->_em->remove($stud);
         $this->_em->flush();
     }
     public function updateAction(\AppBundle\Entity\studentdetails $stud)
     {
         if (!$stud) {
             throw $this->createNotFoundException('No student found for id '.$id );
         }
         $this->_em->persist($stud);
         $this->_em->flush();
     }
}
?>
