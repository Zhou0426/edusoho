<?php

namespace Biz\OrderFacade\Command\Deduct;

use Biz\OrderFacade\Command\Command;
use Biz\OrderFacade\Product\Product;
use AppBundle\Common\MathToolkit;

class PickPaidCoursesCommand extends Command
{
    public function execute(Product $product, $params = array())
    {
        if ($product->targetType != 'classroom') {
            return;
        }

        $classroomSetting = $this->getSettingService()->get('classroom');

        if (empty($classroomSetting['discount_buy'])) {
            return;
        }

        $user = $this->getUser();

        list($paidCourses, $orderItems) = $this->getClassroomService()->findUserPaidCoursesInClassroom($user['id'], $product->targetId);

        foreach ($orderItems as $item) {
            if ($item['pay_amount'] <= 0) {
                continue;
            }

            $deduct = array(
                'deduct_amount' => MathToolkit::simple($item['pay_amount'], 0.01),
                'deduct_type' => 'paidCourse',
                'deduct_id' => $item['target_id'],
            );
            $product->pickedDeducts[] = $deduct;
        }
    }

    private function getClassroomService()
    {
        return $this->biz->service('Classroom:ClassroomService');
    }

    private function getSettingService()
    {
        return $this->biz->service('System:SettingService');
    }

    private function getOrderService()
    {
        return $this->biz->service('Order:OrderService');
    }

    private function getCourseMemberService()
    {
        return $this->biz->service('Course:MemberService');
    }

    protected function getUser()
    {
        $biz = $this->biz;

        return $biz['user'];
    }
}