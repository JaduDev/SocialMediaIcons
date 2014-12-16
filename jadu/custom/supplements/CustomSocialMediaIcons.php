<?php
	/**
	* Accordion supplement widget.
	*
	* @package Custom Social Media Icons
	* @copyright All Contents (c) 2014 Messiah College
	* @author Jonathan Wheat, Messiah College.
	*/

	/**
	* The database table used to hold contacts
	*/
	define("SOCIALMEDIAICONS_SUPPLEMENT_TABLE", "CustomSocialMediaIcons");

	include_once("JaduADODB.php");
	include_once("JaduCache.php");
	include_once("websections/JaduPageSupplements.php");

	/**
	* The SocialMediaIcons class contains a set of fields relating to a SocialMediaIconsSupplementWidget.
	*
	* @package custom
	*/
	class SocialMediaIcons
	{

		/**
		* The id of the {@link SocialMediaIconsSupplement} in the database.
		* @access public
		* @var integer
		*/
		var $id = -1;

		/**
		* The title assigned to this {@link SocialMediaIconsSupplement}
		* @access public
		* @var string
		*/
		var $title = '';

		/**
		* The url for facebook
		* @access public
		* @var string
		*/
		var $url_facebook = '';

		/**
		* The url for twitter
		* @access public
		* @var string
		*/
		var $url_twitter = '';

		/**
		* The url for vimeo
		* @access public
		* @var string
		*/
		var $url_vimeo = '';

		/**
		* The url for youtube
		* @access public
		* @var string
		*/
		var $url_youtube = '';

		/**
		* The url for google plus
		* @access public
		* @var string
		*/
		var $url_googleplus = '';

		/**
		* The url for linkedin
		* @access public
		* @var string
		*/
		var $url_linkedin = '';

		/**
		* The url for wordpress
		* @access public
		* @var string
		*/
		var $url_wordpress = '';

		/**
		* The url for blogspot
		* @access public
		* @var string
		*/
		var $url_blogspot = '';

	}

	/**
	 * Build the SQL query for the given criteria.
	 *
	 * @param array[string]string $criteria Fields to search for as keys mapped to values to match against.
	 * @param array[]string $order List of fields to order results by
	 * @param boolean $count Whether the query is a COUNT query
	 * @return string The generated SQL query
	 */
	function buildSocialMediaIconsSupplementQuery($criteria = array(), $order = array(),$count = false)
	{
		global $db;

		$whereClause = '';

		if (isset($criteria['id'])) {
			$whereClause .= (empty($whereClause) ? 'WHERE' : 'AND') . ' id = ' . intval($criteria['id']) . ' ';
		}

		if (isset($criteria['title'])) {
			$whereClause .= (empty($whereClause) ? 'WHERE' : 'AND') . ' title = ' . $db->qstr($criteria['title']) . ' ';
		}

		if (isset($criteria['except'])) {
			if (!is_array($criteria['except'])) {
				$criteria['except'] = array($criteria['except']);
			}
			$whereClause .= (empty($whereClause) ? 'WHERE' : 'AND') . ' id NOT IN (' . implode(',', array_map('intval', $criteria['except'])) . ') ';
		}

		$orderClause = '';

		// Build the query string
		if ($count) {
			$query = 'SELECT COUNT(*) AS numRows ';
		}
		else {
			$query = 'SELECT id, title,url_facebook,url_twitter,url_vimeo,url_youtube,url_googleplus,url_linkedin,url_wordpress,url_blogspot ';

			// Order by
			if (is_string($order)) {
				$order = array($order);
			}

			if (count($order) > 0) {
				$orderClause = 'ORDER BY ' . implode(',', $order) . ' ';
			}
			else {
				$orderClause = 'ORDER BY title ASC';
			}
		}

		$query .= 'FROM ' . SOCIALMEDIAICONS_SUPPLEMENT_TABLE . ' ' .
				  $whereClause .
				  $orderClause;

		return $query;
	}


	/**
	 * Fetch a single {@link SocialMediaIcons} item using the given query.
	 *
	 * @param string $query The query to execute.
	 * @return SocialMediaIcons A single matching SocialMediaIcons or an empty SocialMediaIcons object.
	 */
	function fetchSocialMediaIconsSupplementWithQuery($query)
	{
		global $db;

		$cache = new Cache(SOCIALMEDIAICONS_SUPPLEMENT_TABLE, $query);
		if ($cache->isEmpty()) {
			$supplement = new SocialMediaIcons();
			$result = $db->SelectLimit($query, 1);
			if ($result && !$result->EOF) {
				$supplement->id = (int) $result->fields['id'];
				$supplement->title = $result->fields['title'];
				$supplement->url_facebook = $result->fields['url_facebook'];
				$supplement->url_twitter = $result->fields['url_twitter'];
				$supplement->url_vimeo = $result->fields['url_vimeo'];
				$supplement->url_youtube = $result->fields['url_youtube'];
				$supplement->url_googleplus = $result->fields['url_googleplus'];
				$supplement->url_linkedin = $result->fields['url_linkedin'];
				$supplement->url_wordpress = $result->fields['url_wordpress'];
				$supplement->url_blogspot = $result->fields['url_blogspot'];

			}

			$cache->setData($supplement);
			return $supplement;
		}

		return $cache->data;		
	}


	/**
	 * Fetch all the {@link SocialMediaIconsSupplement} for the given query.
	 *
	 * @param string $query The SQL query to execute
	 * @param integer $limit The number of records to return (null = all)
	 * @param integer $offset The position in the result set to begin returning records from
	 * @return array[]SocialMediaIconsSupplement Array of matching SocialMediaIconsSupplement objects
	 */
	function fetchAllSocialMediaIconsSupplementsWithQuery($query, $limit = null, $offset = null)
	{
		global $db;

		$cacheId = $query;
		if ($limit !== null) {
			$cacheId .= ' LIMIT ' . (int) $limit . ',' . (int) $offset;
		}

		$cache = new Cache(SOCIALMEDIAICONS_SUPPLEMENT_TABLE, $cacheId);
		if ($cache->isEmpty()) {
			if ($limit === null) {
				$result = $db->Execute($query);
			}
			else {
				$result = $db->SelectLimit($query, $limit, $offset);
			}

			$supplements = array();
			if ($result) {
				while (!$result->EOF) {
					$supplement = new SocialMediaIcons();
					$supplement->id = (int) $result->fields['id'];
					$supplement->title = $result->fields['title'];
					$supplement->url_facebook = $result->fields['url_facebook'];
					$supplement->url_twitter = $result->fields['url_twitter'];
					$supplement->url_vimeo = $result->fields['url_vimeo'];
					$supplement->url_youtube = $result->fields['url_youtube'];
					$supplement->url_googleplus = $result->fields['url_googleplus'];
					$supplement->url_linkedin = $result->fields['url_linkedin'];
					$supplement->url_wordpress = $result->fields['url_wordpress'];
					$supplement->url_blogspot = $result->fields['url_blogspot'];
					$supplements[] = $supplement;

					$result->MoveNext();
				}
			}

			$cache->setData($supplements);
			return $supplements;
		}

		return $cache->data;		
	}


	/**
	 * Creates a new Accordion supplement record in the database.
	 *
	 * @param SocialMediaIconsSupplement $SocialMediaIconsSupplement An instance of SocialMediaIconsSupplement to add to the database.
	 * @return integer The database id of the newly created record.
	 */
	function newSocialMediaIconsSupplement($SocialMediaIconsSupplement)
	{
		global $db;

		$query = 'INSERT INTO ' . SOCIALMEDIAICONS_SUPPLEMENT_TABLE . ' ' .
				 '(title, url_facebook,url_twitter,url_vimeo,url_youtube,url_googleplus,
				   url_linkedin,url_wordpress,url_blogspot
				   ) VALUES (' .
				 $db->qstr($SocialMediaIconsSupplement->title) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_facebook) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_twitter) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_vimeo) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_youtube) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_googleplus) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_linkedin) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_wordpress) . ',' .
				 $db->qstr($SocialMediaIconsSupplement->url_blogspot) . ')';

		$db->Execute($query);
		$id = $db->Insert_ID();

		if ($id > 0) {
			deleteTableCache(SOCIALMEDIAICONS_SUPPLEMENT_TABLE);
		}

		return (int) $id;		
	}


	/**
	 * Update a Accordion supplement database record.
	 *
	 * @param SocialMediaIconsSupplement $SocialMediaIconsSupplement An instance of SocialMediaIconsSupplement with the details to update.
	 */
	function updateSocialMediaIconsSupplement($SocialMediaIconsSupplement)
	{
		global $db;

		$query = 'UPDATE ' . SOCIALMEDIAICONS_SUPPLEMENT_TABLE . ' SET ' .
				 'title = ' . $db->qstr($SocialMediaIconsSupplement->title) . ',' .
				 'url_facebook = ' . $db->qstr($SocialMediaIconsSupplement->url_facebook) . ', ' .
				 'url_twitter = ' . $db->qstr($SocialMediaIconsSupplement->url_twitter) . ', ' .
				 'url_vimeo = ' . $db->qstr($SocialMediaIconsSupplement->url_vimeo) . ', ' .
				 'url_youtube = ' . $db->qstr($SocialMediaIconsSupplement->url_youtube) . ', ' .
				 'url_googleplus = ' . $db->qstr($SocialMediaIconsSupplement->url_googleplus) . ', ' .
				 'url_linkedin = ' . $db->qstr($SocialMediaIconsSupplement->url_linkedin) . ', ' .
				 'url_wordpress = ' . $db->qstr($SocialMediaIconsSupplement->url_wordpress) . ', ' .
				 'url_blogspot = ' . $db->qstr($SocialMediaIconsSupplement->url_blogspot) . ' ' .
				 'WHERE id = ' . intval($SocialMediaIconsSupplement->id);

		$db->Execute($query);
		$affectedRows = $db->Affected_Rows();

		if ($affectedRows > 0) {
			deleteTableCache(SOCIALMEDIAICONS_SUPPLEMENT_TABLE);
		}

		return (bool) $affectedRows;

	}

	/**
	 * Delete a SocialMediaIconsSupplement in the database.
	 *
	 * @param integer $id The id of the SocialMediaIconsSupplement to be deleted.
	 */
	function deleteSocialMediaIconsSupplement($id)
	{
		global $db;

		$query = 'DELETE FROM ' . SOCIALMEDIAICONS_SUPPLEMENT_TABLE . ' ' .
				 'WHERE id = ' . intval($id);

		$db->Execute($query);
		$affectedRows = $db->Affected_Rows();

		if ($affectedRows > 0) {
			// Delete all supplements referencing this record
			deletePageSupplementForRecord($id);
			deleteTableCache(SOCIALMEDIAICONS_SUPPLEMENT_TABLE);
		}

		return (bool) $affectedRows;
	}		



	/**
	 * A function to return an array of SocialMediaIconsSupplement objects.
	 *
	 * @param array[string]string $criteria Fields to search for as keys mapped to values to match against.
	 * @param array[]string $order List of fields to order results by
	 * @param integer $limit The number of records to return (null = all)
	 * @param integer $offset The position in the result set to begin returning records from
	 * @return array[]SocialMediaIconsSupplement Returns an array of SocialMediaIconsSupplement objects.
	 */
	function getAllSocialMediaIconsSupplements($criteria = array(), $order = array(), $limit = null, $offset = null)
	{
		$query = buildSocialMediaIconsSupplementQuery($criteria, $order);
		return fetchAllSocialMediaIconsSupplementsWithQuery($query, $limit, $offset);		
	}

	/**
	 * Returns the number of Social Media Icon supplements that match a given criteria
	 *
	 * @param array[string]string $criteria Fields to search for as keys mapped to values to match against.
	 * @return integer The number of SocialMediaIconsSupplements matching the given criteria
	 */
	function countSocialMediaIconsSupplements($criteria = array())
	{
		global $db;

		$query = buildSocialMediaIconsSupplementQuery($criteria, array(), true);

		$cache = new Cache(SOCIALMEDIAICONS_SUPPLEMENT_TABLE, $query);
		if ($cache->isEmpty()) {
			$count = 0;
			$result = $db->Execute($query);
			if ($result && !$result->EOF) {
				$count = (int) $db->GetOne($query);
			}

			$cache->setData($count);
			return $count;
		}

		return $cache->data;		
	}

	/**
	 * Get an {@link SocialMediaIconsSupplement} record from the database.
	 *
	 * @param integer $id The id of the SocialMediaIconsSupplement you want.
	 * @return SocialMediaIconsSupplement Returns an instance of SocialMediaIconsSupplement.
	 */
	function getCustomSocialMediaIcons($id)
	{
		$query = buildSocialMediaIconsSupplementQuery(array('id' => $id));
		return fetchSocialMediaIconsSupplementWithQuery($query);		
	}

	/**
	 * Get an {@link SocialMediaIconsSupplement} record from the database by title
	 *
	 * @param string $title The title of the SocialMediaIconsSupplement you want.
	 * @return SocialMediaIconsSupplement Returns an instance of SocialMediaIconsSupplement.
	 */
	function getSocialMediaIconsSupplementByTitle($title)
	{
		$query = buildSocialMediaIconsSupplementQuery(array('title' => $title));
		return fetchSocialMediaIconsSupplementWithQuery($query);		
	}

	/**
	* Check that a SocialMediaIconsSupplement record is suitable for adding to the database.
	*
	* @param SocialMediaIconsSupplement $SocialMediaIconsSupplement An insdtance of SocialMediaIconsSupplement
	* @return array An associative array with the fields that contain errors
	*/
	function validateSocialMediaIconsSupplement($SocialMediaIconsSupplement)
	{
		$errors = array();

		if (empty($SocialMediaIconsSupplement->title)) {
			$errors['title'] = true;
		}
		else {
			$numSupplements = countSocialMediaIconsSupplements(array(
				'title' => $SocialMediaIconsSupplement->title,
				'except' => $SocialMediaIconsSupplement->id
			));

			if ($numSupplements > 0) {
				// Title must be unique
				$errors['title'] = true;
			}
		}

		/**
		 * If you want more validation use a block like this and change the database field
		 * and object variable name
		 *
		 * if (empty($SocialMediaIconsSupplement->description)) {
		 *	$errors['description'] = true;
		 * }
		 */

		return $errors;		
	}

?>
