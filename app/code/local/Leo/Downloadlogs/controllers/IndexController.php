<?php
class Leo_Downloadlogs_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/downloadlogs?id=15 
    	 *  or
    	 * http://site.com/downloadlogs/id/15 	
    	 */
    	/* 
		$downloadlogs_id = $this->getRequest()->getParam('id');

  		if($downloadlogs_id != null && $downloadlogs_id != '')	{
			$downloadlogs = Mage::getModel('downloadlogs/downloadlogs')->load($downloadlogs_id)->getData();
		} else {
			$downloadlogs = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($downloadlogs == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$downloadlogsTable = $resource->getTableName('downloadlogs');
			
			$select = $read->select()
			   ->from($downloadlogsTable,array('downloadlogs_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$downloadlogs = $read->fetchRow($select);
		}
		Mage::register('downloadlogs', $downloadlogs);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}