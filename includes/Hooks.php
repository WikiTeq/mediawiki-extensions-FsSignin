<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @file
 */

namespace MediaWiki\Extension\FsSignin;

use Skin;
use Title;
use OutputPage;
use User;
use WebRequest;
use MediaWiki;
use SpecialPage;
use ExtensionRegistry;

class Hooks {

	/**
	 * Grab the page request early
	 * See https://www.mediawiki.org/wiki/Manual:Hooks/BeforeInitialize
	 * Redirects ASAP to login
	 * @param Title &$title being used for request
	 * @param null $article unused
	 * @param OutputPage $out object
	 * @param User $user current user
	 * @param WebRequest $request why we're here
	 * @param MediaWiki $mw object
	 *
	 * Note that $title has to be passed by ref so we can replace it.
	 */
	public static function doSignin ( Title &$title, $article, OutputPage $out, User $user,
			WebRequest $request, MediaWiki $mw ) {
		$sessionId = null;
	 	$sessionId = @$_COOKIE['fssessionid'];
		$wikiSessionId = @$_COOKIE['wiki_en_session'];

		if ($wikiSessionId) {
			// we want to signin to the other language wikis
		}

		// bb46c487-5df6-4ead-9ebc-289b44a6f0c6-prod
		// echo "Looking for session $sessionId";
	 	if ( !is_null( $sessionId ) && !empty( $sessionId) ) {

			if ( $GLOBALS['wgPluggableAuth_EnableAutoLogin'] ) {
				return;
			}
			if ( !$out->getUser()->isAnon() ) {
				// $out->getUser()->mName is the username
				return;
			}
			// make sure we test if the session is expired before we auto-login
			// example 1135c3c1-4dc9-477c-b5dd-c41c57f6bedf-prod
			// OLD $ch = curl_init("https://ident.familysearch.org/cis-public-api/v4/session/$sessionId");
			$ch = curl_init("https://ident.familysearch.org/service/ident/cis/cis-public-api/v4/session/$sessionId");
			// When we curl_exec, return a string rather than output directly
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			// Ask for JSON instead of XML
			$headers = ["Accept: application/json"];
			curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
			// Send our session cookie in the request
			curl_setopt ($ch, CURLOPT_COOKIE, "fssessionid=$sessionId");
			$json = curl_exec($ch);
			curl_close($ch);
			$objJson = json_decode($json);

			// print '<pre>'; var_dump($objJson); print '</pre>'; exit();
			// make sure we have a valid user before we auto-login
			// if the session is stale, we'll have a statusCode of 453
			// if there is no session, we'll have a user count of zero
			if ( 
			     ( !empty($objJson->statusCode) && ( $objJson->statusCode == 453 ) ) || 
			     ( !count($objJson->users) )
			   ) {
				return;
			}

			$loginSpecialPages = ExtensionRegistry::getInstance()->getAttribute(
				'PluggableAuthLoginSpecialPages'
			);
			foreach ( $loginSpecialPages as $page ) {
				if ( $title->isSpecial( $page ) ) {
					return;
				}
			}
			$oldTitle = $title;
			$title = SpecialPage::getTitleFor( 'Userlogin' );
			header( 'Location: ' . $title->getFullURL( [
				'returnto' => $oldTitle,
				'returntoquery' => $request->getRawQueryString()
			] ) );
			exit;

		} else {
			// anonymous user; do nothing
		}
	}

}
