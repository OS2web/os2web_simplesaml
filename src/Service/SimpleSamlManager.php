<?php

namespace Drupal\os2web_simplesaml\Service;

/**
 * Class SimpleSamlManager.
 *
 * Various utilities to help working with SimpleSaml.
 */
class SimpleSamlManager {

  /**
   * Extracts the attribute from the current SimpleSAML session.
   *
   * Difference between the standard function is that it support format for
   * specifying the attribute index.
   *
   * E.g. key "eduPersonAffiliation" will allways fetch attribute with index 0.
   * With this function it is possibe to fetch values from other indices as well.
   * For example "eduPersonAffiliation[1]" will fetch attribute with index 1.
   *
   * @param $attribute
   *  Identifier of an attribute, e.g. eduPersonAffiliation or
   *  eduPersonAffiliation[1].
   *
   * @return bool|mixed|null
   * @throws \Drupal\simplesamlphp_auth\Exception\SimplesamlphpAttributeException
   */
  function extractAttribute($attribute) {
    /** @var \Drupal\simplesamlphp_auth\Service\SimplesamlphpAuthManager $simplesaml */
    $simplesaml = \Drupal::service('simplesamlphp_auth.manager');

    // Checking if we have a plain attribute, or attribute with index.
    // In case of plain attribute, use the default function.
    if (preg_match_all('/(\S*)\[(\d+)\]/', $attribute, $matches)) {
      $attribute_name = $matches[1][0];
      $attribute_index = $matches[2][0];

      $attributes = $simplesaml->getAttributes();

      if (isset($attributes)) {
        if (!empty($attributes[$attribute_name][$attribute_index])) {
          return $attributes[$attribute_name][$attribute_index];
        }
      }
    }
    else {
      return $simplesaml->getAttribute($attribute);
    }

    return NULL;
  }
}
