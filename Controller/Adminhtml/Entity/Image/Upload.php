<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ScopedEav
 * @author    Maxime LECLERCQ <maxime.leclercq@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\ScopedEav\Controller\Adminhtml\Entity\Image;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Scoped EAV uploader controller.
 *
 * @category Smile
 * @package  Smile\ScopedEav
 * @author   Maxime LECLERCQ <maxime.leclercq@smile.fr>
 */
class Upload extends Action implements HttpPostActionInterface
{
    /**
     * @var \Magento\Catalog\Model\ImageUploader
     */
    private $imageUploader;

    /**
     * Upload constructor.
     *
     * @param Action\Context                       $context       Context.
     * @param \Magento\Catalog\Model\ImageUploader $imageUploader Image uploader.
     */
    public function __construct(
        Action\Context $context,
        \Magento\Catalog\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // @todo need https://patch-diff.githubusercontent.com/raw/magento/magento2/pull/19249.patch
        $imageId = $this->_request->getParam('param_name');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
