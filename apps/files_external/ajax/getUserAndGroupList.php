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

if (isset($_GET['offset'])) {
	$offset = $_GET['offset'];
} else {
	$offset = 0;
}
$searchGroups = false;
if (isset($_GET['groupOffset'])) {
	$offset -= $_GET['groupOffset'];
	$searchGroups = true;
}
if (isset($_GET['limit'])) {
	$limit = $_GET['limit'];
} else {
	$limit = 10;
}
if (isset($_GET['pattern']) && !empty($_GET['pattern'])) {
	$pattern = $_GET['pattern'];
} else {
	$pattern = '';
}

$users = $groups = array();
$query  = array('term' => $pattern, 'offset' => $offset);

if(!$searchGroups) {
	$users  = \OCP\User::getDisplayNames($pattern, $limit, $offset);
}
if($searchGroups || count($users) === 0) {
	if(!$searchGroups) {
		$offset = 0;
	}
	$groups = OC_Group::getGroups($pattern, $limit, $offset);
}

$result = array('users' => $users, 'groups' => $groups, 'query' => $query);

\OCP\JSON::success(array('data' => $result));
