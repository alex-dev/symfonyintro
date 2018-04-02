<?php
namespace AppBundle\Entity\Client;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Address {
  const civic_length = 15;
  const city_length = 15;
  const province_length = 2;
  const postal_length = 6;

  /**
   * @ORM\Column(type="string", length=Address::civic_length)
   * @Assert\Length(min=2, max=15, minMessage="civic.tooshort", maxMessage="civic.toolong")
   * @Assert\NotBlank(message="civic.blank")
   */
  protected $civicNumberAndRoad;

  public function getCivic() {
    return $this->civicNumberAndRoad;
  }

  /**
   * @ORM\Column(type="string", length=Address::city_length)
   * @Assert\Length(min=2, max=15, minMessage="city.tooshort", maxMessage="city.toolong")
   * @Assert\NotBlank(message="city.blank")
   */
  protected $city;

  public function getCity() {
    return $this->city;
  }

  /**
   * @ORM\Column(type="string", length=Address::province_length)
   * @Assert\Choice(callback="getAllProvincesIds", message="province.notChoice")
   * @Assert\NotBlank(message="province.blank")
   */
  protected $province;

  public function getProvince() {
    return $this->province;
  }

  /**
   * @ORM\Column(type="string", length=Address::postal_length)
   * @Assert\Regex(
   *   pattern="/^[A-CEGHJ-NPR-TV-Za-ceghj-npr-tv-z][0-9][A-CEGHJ-NPR-TV-Za-ceghj-npr-tv-z] ?[0-9][A-CEGHJ-NPR-TV-Za-ceghj-npr-tv-z][0-9]$/",
   *   message="postal.invalid")
   * @Assert\NotBlank(message="postal.blank")
   */
  protected $postalCode;

  public function getPostalCode() {
    return $this->postalCode;
  }

  public function getAllProvinceIds() {
    return array_keys(getAllProvinces('en_CA'));
  }

  public function getAllProvinces($locale) {
    return [
      'AB' => 'Alberta',
      'BC' => $locale == 'fr_CA' ? 'Colombie-Britannique' : 'British Columbia',
      'MB' => 'Manitoba',
      'NB' => $locale == 'fr_CA' ? 'Nouveau-Brunswick' : 'New Brunswick',
      'NL' => $locale == 'fr_CA' ? 'Terre-Neuve-et-Labrador' : 'Newfoundland and Labrador',
      'NS' => $locale == 'fr_CA' ? 'Nouvelle-Écosse' : 'Nova Scotia',
      'NT' => $locale == 'fr_CA' ? 'Territoires du Nord-Ouest' : 'Northwest Territories',
      'NU' => 'Nunavut',
      'ON' => 'Ontario',
      'PE' => $locale == 'fr_CA' ? 'Île-du-Prince-Édouard' : 'Prince Edward Island',
      'QC' => $locale == 'fr_CA' ? 'Québec' : 'Quebec',
      'SK' => 'Saskatchewan',
      'YT' => 'Yukon'
    ];
  }
}