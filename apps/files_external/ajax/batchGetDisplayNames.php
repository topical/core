<?php
/**
 * ownCloud
 *
 * @author Arthur Schiwon
 * @copyright 2014 Arthur Schiwon <blizzz@owncloud.com>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

\OCP\JSON::callCheck();
\OCP\JSON::checkAdminUser();

if (isset($_GET['uids']) && !empty($_GET['uids'])) {
	$uids = $_GET['uids'];
} else {
	\OCP\JSON::success();
	exit();
}

$l=OC_L10N::get('files_external');
$result = array();
foreach($uids as $uid) {
	if(!\OCP\User::userExists($uid) && $uid !== 'all') {
		continue;
	}
	$displayName = \OCP\User::getDisplayName($uid);
	if(!is_null($displayName)) {
		if($displayName === 'all' && $uid === 'all') {
			$displayName = $l->t('All Users');
		}
		$result[] = array(
			'name' => $uid,
			'displayname' => $displayName,
			'type' => 'user',
		);
	}
}
\OCP\JSON::success(array('data' => $result));
