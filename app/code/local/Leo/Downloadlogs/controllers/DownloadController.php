<?php 
require_once("Mage/Downloadable/controllers/DownloadController.php");
class Leo_Downloadlogs_DownloadController extends Mage_Downloadable_DownloadController
{
	
	 protected function _processZip($resource, $resourceType)
	{
		$helper = Mage::helper('downloadable/file');
   


    $fileName       = $helper->getFileFromPathFile($resource);
    $contentType    = $helper->getFileType($resource);
		Mage::log("_processZip called: contentType is ".$contentType, null, 'controller.log');
		if($resourceType === Mage_Downloadable_Helper_Download::LINK_TYPE_FILE && $contentType === "application/zip")
		{
			$io = new Varien_Io_File();
			$zip = new ZipArchive;
			$destDir = Mage::getBaseDir('var');
			$destFile = $destDir. DS. 'test.zip';
		
			
				$io->open(array('path'=>$destDir));
			if (!$io->fileExists($destFile, true)) {
				   Mage::log("_processZip called: destFile is not exists ", null, 'controller.log');
					 $io->cp($resource, $destFile);
					 
					 if ($zip->open($destFile) === TRUE) {
					    $zip->addFromString('test.txt', 'demo text');
					    $zip->close();
					    
					 }
			
			}
			
			Mage::log("_processZip called: file: ".$destFile, null, 'controller.log');
			$this->_processDownload($destFile, Mage_Downloadable_Helper_Download::LINK_TYPE_FILE);
			$io->rm($destFile);
		}
		else 
		{
			$this->_processDownload($resource, $resourceType);
		}
		
	}
	 /**
     * Download link action
     */
    public function linkAction()
    {
			  Mage::log("Download link called", null, 'controller.log');
        $id = $this->getRequest()->getParam('id', 0);
        $linkPurchasedItem = Mage::getModel('downloadable/link_purchased_item')->load($id, 'link_hash');
        if (! $linkPurchasedItem->getId() ) {
            $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__("Requested link does not exist."));
            return $this->_redirect('*/customer/products');
        }
        if (!Mage::helper('downloadable')->getIsShareable($linkPurchasedItem)) {
            $customerId = $this->_getCustomerSession()->getCustomerId();
            if (!$customerId) {
                $product = Mage::getModel('catalog/product')->load($linkPurchasedItem->getProductId());
                if ($product->getId()) {
                    $notice = Mage::helper('downloadable')->__(
                        'Please log in to download your product or purchase <a href="%s">%s</a>.',
                        $product->getProductUrl(), $product->getName()
                    );
                } else {
                    $notice = Mage::helper('downloadable')->__('Please log in to download your product.');
                }
                $this->_getCustomerSession()->addNotice($notice);
                $this->_getCustomerSession()->authenticate($this);
                $this->_getCustomerSession()->setBeforeAuthUrl(Mage::getUrl('downloadable/customer/products/'),
                    array('_secure' => true)
                );
                return ;
            }
            $linkPurchased = Mage::getModel('downloadable/link_purchased')->load($linkPurchasedItem->getPurchasedId());
            if ($linkPurchased->getCustomerId() != $customerId) {
                $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__("Requested link does not exist."));
                return $this->_redirect('*/customer/products');
            }
        }
        $downloadsLeft = $linkPurchasedItem->getNumberOfDownloadsBought()
            - $linkPurchasedItem->getNumberOfDownloadsUsed();

        $status = $linkPurchasedItem->getStatus();
        if ($status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_AVAILABLE
            && ($downloadsLeft || $linkPurchasedItem->getNumberOfDownloadsBought() == 0)
        ) {
            $resource = '';
            $resourceType = '';
            if ($linkPurchasedItem->getLinkType() == Mage_Downloadable_Helper_Download::LINK_TYPE_URL) {
                $resource = $linkPurchasedItem->getLinkUrl();
                $resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_URL;
            } elseif ($linkPurchasedItem->getLinkType() == Mage_Downloadable_Helper_Download::LINK_TYPE_FILE) {
                $resource = Mage::helper('downloadable/file')->getFilePath(
                    Mage_Downloadable_Model_Link::getBasePath(), $linkPurchasedItem->getLinkFile()
                );
                $resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
            }
            try {
								Mage::log("Download link called, prepare process zip", null, 'controller.log');
                $this->_processZip($resource, $resourceType);
                $linkPurchasedItem->setNumberOfDownloadsUsed($linkPurchasedItem->getNumberOfDownloadsUsed() + 1);

                if ($linkPurchasedItem->getNumberOfDownloadsBought() != 0 && !($downloadsLeft - 1)) {
                    $linkPurchasedItem->setStatus(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED);
                }
                $linkPurchasedItem->save();
								//process download log
								 $linkPurchased = Mage::getModel('downloadable/link_purchased')->load($linkPurchasedItem->getPurchasedId());
								$model = Mage::getModel('downloadlogs/downloadlogs');	
								$data = array("user_id" => $this->_getCustomerSession()->getCustomerId(),
														"product_name" => $linkPurchased->getProductName(),
														"created_time" => now() );
								$model->setData($data);
								$flag = $model->save();		
								Mage::log("Download link called, model save: ".$flag, null, 'controller.log');				
                exit(0);
            }
            catch (Exception $e) {
								Mage::log("Download link called, process zip error. ". $e, null, 'controller.log');
                $this->_getCustomerSession()->addError(
                    Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.')
                );
            }
        } elseif ($status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED) {
            $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__('The link has expired.'));
        } elseif ($status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PENDING
            || $status == Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PAYMENT_REVIEW
        ) {
            $this->_getCustomerSession()->addNotice(Mage::helper('downloadable')->__('The link is not available.'));
        } else {
            $this->_getCustomerSession()->addError(
                Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.')
            );
        }
        return $this->_redirect('*/customer/products');
    }
}

?>