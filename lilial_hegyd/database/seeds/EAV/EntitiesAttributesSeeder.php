<?php

namespace Database\Seeds\EAV;

use App\Models\Sale\Contact;
use App\Models\Communication\Ticket;
use App\Models\Communication\TicketMessage;
use App\Models\Content\CommunicationPlan;
use App\Models\EAV\Attribute;
use App\Models\EAV\AttributeValue;
use Illuminate\Database\Seeder;

class EntitiesAttributesSeeder extends Seeder
{

    public function run()
    {

        // Prepare generic attributes
        $attributesData = [
//
//            // TICKETS
//            [
//                'class_name'              => Ticket::class,
//                // Field name
//                'field_name'              => 'type',
//                // Unique string key for seeder insertion
//                'key'                     => 'ticket.type',
//                'translate_key_entity'    => 'eav.datas.ticket.entity',
//                'translate_key_attribute' => 'eav.datas.ticket.attributes.type',
//                'with_color'              => false,
//                'with_roles'              => false,
//                'with_users'              => true,
//            ],
//            [
//                'class_name'              => Ticket::class,
//                'field_name'              => 'status',
//                'key'                     => 'ticket.status',
//                'translate_key_entity'    => 'eav.datas.ticket.entity',
//                'translate_key_attribute' => 'eav.datas.ticket.attributes.status',
//                'with_color'              => true,
//                'with_roles'              => false,
//                'with_users'              => false,
//            ],
//
//
//            // CONTACTS
//            [
//                'class_name'              => Contact::class,
//                // Field name
//                'field_name'              => 'origin',
//                // Unique string key for seeder insertion
//                'key'                     => 'contact.origin',
//                'translate_key_entity'    => 'eav.datas.contact.entity',
//                'translate_key_attribute' => 'eav.datas.contact.attributes.origin',
//            ],
//
//            // CONTACTS
//            [
//                'class_name'              => Contact::class,
//                // Field name
//                'field_name'              => 'company_type',
//                // Unique string key for seeder insertion
//                'key'                     => 'contact.company_type',
//                'translate_key_entity'    => 'eav.datas.contact.entity',
//                'translate_key_attribute' => 'eav.datas.contact.attributes.company_type',
//            ],
//
//            // PLAN DE COM
//            /*[
//                'class_name'                => CommunicationPlan::class,
//                'field_name'                => 'category',
//                'key'                       => 'category.com_plan',
//                'translate_key_entity'      => 'eav.datas.com_plan.entity',
//                'translate_key_attribute'   => 'eav.datas.com_plan.attributes.category',
//                'with_color'                => true,
//                'with_roles'                => false,
//                'with_users'                => false,
//            ],
//            [
//                'class_name'                => CommunicationPlan::class,
//                'field_name'                => 'typology',
//                'key'                       => 'typology.com_plan',
//                'translate_key_entity'      => 'eav.datas.com_plan.entity',
//                'translate_key_attribute'   => 'eav.datas.com_plan.attributes.typology',
//                'with_color'                => false,
//                'with_roles'                => false,
//                'with_users'                => false,
//            ],*/
//
//            // CRM
//            /*[
//                'class_name'                => '\\',
//                'field_name'                => 'status',
//                'key'                       => 'status.candidature',
//                'translate_key_entity'      => 'eav.datas.candidature.entity',
//                'translate_key_attribute'   => 'eav.datas.candidature.attributes.status',
//                'with_color'                => false,
//                'with_roles'                => false,
//                'with_users'                => false,
//            ],*/
        ];

        $attributeValuesData = [

//            // TICKETS
//            /// CATEGORY
//            'ticket.type'          => [
//                [
//                    'value'    => 'Passerelle pub',
//                    'key'      => 'ticket.type.type_1',
//                    'color'    => null,
//                    'position' => 0,
//                ],
//                [
//                    'value'    => 'Fonctionnement logiciel',
//                    'key'      => 'ticket.type.type_2',
//                    'color'    => null,
//                    'position' => 1,
//                ],
//                [
//                    'value'    => 'Bug site gnimmo',
//                    'key'      => 'ticket.type.type_3',
//                    'color'    => null,
//                    'position' => 2,
//                ],
//                [
//                    'value'    => 'Facturation cotisation gni',
//                    'key'      => 'ticket.type.type_4',
//                    'color'    => null,
//                    'position' => 3,
//                ],
//                [
//                    'value'    => 'Facturation service centrale d’achat',
//                    'key'      => 'ticket.type.type_5',
//                    'color'    => null,
//                    'position' => 4,
//                ],
//                [
//                    'value'    => 'Réseaux sociaux',
//                    'key'      => 'ticket.type.type_6',
//                    'color'    => null,
//                    'position' => 5,
//                ],
//                [
//                    'value'    => 'Reportage photo',
//                    'key'      => 'ticket.type.type_7',
//                    'color'    => null,
//                    'position' => 6,
//                ],
//                [
//                    'value'    => 'Création graphique',
//                    'key'      => 'ticket.type.type_8',
//                    'color'    => null,
//                    'position' => 7,
//                ],
//                [
//                    'value'    => 'Défaut fabrication ou livraison supports de communication',
//                    'key'      => 'ticket.type.type_9',
//                    'color'    => null,
//                    'position' => 8,
//                ],
//                [
//                    'value'    => 'Problème tarif ou service partenaire GNI',
//                    'key'      => 'ticket.type.type_10',
//                    'color'    => null,
//                    'position' => 9,
//                ],
//                [
//                    'value'    => 'Problème inter-agence',
//                    'key'      => 'ticket.type.type_11',
//                    'color'    => null,
//                    'position' => 10,
//                ],
//                [
//                    'value'    => 'Problème ambassadeurs',
//                    'key'      => 'ticket.type.type_12',
//                    'color'    => null,
//                    'position' => 11,
//                ],
//                [
//                    'value'    => 'Demande diverse hors catégories précédentes',
//                    'key'      => 'ticket.type.type_13',
//                    'color'    => null,
//                    'position' => 12,
//                ],
//
//            ],
//            /// STATUS
//            'ticket.status'        => [
//                [
//                    'value'     => 'En attente de prise en compte',
//                    'key'       => 'ticket.status.status_waiting',
//                    'color'     => '#ED4040', // Rouge
//                    'position'  => 0,
//                    'removable' => false,
//                    /// When an attribute value can not be removed, it could may be interesting to rename it
//                    //'renamable'     => true,
//                    /// Allow admin to move value (alter value position in the sets of values)
//                    /// Could be interesting to but complicated in the process
//                    /// If others values can be moved, but not this one, we can move all others...
//                    //'movable'     => true,
//                ],
//                [
//                    'value'     => 'En cours',
//                    'key'       => 'ticket.status.status_processing',
//                    'color'     => '#F1C411', // Orange
//                    'position'  => 1,
//                    'removable' => false,
//                ],
//                [
//                    'value'     => 'Clôturé',
//                    'key'       => 'ticket.status.status_closed',
//                    'color'     => '#00C292', // Vert
//                    'position'  => 2,
//                    'removable' => false,
//                ],
//            ],
//
//            // CONTACTS
//            /// COMPANY TYPE
//            'contact.company_type' => [
//                [
//                    'value'    => 'EURL',
//                    'key'      => 'contact.company_type.eurl',
//                    'color'    => null,
//                    'position' => 0,
//                ],
//                [
//                    'value'    => 'SARL',
//                    'key'      => 'contact.company_type.sarl',
//                    'color'    => null,
//                    'position' => 1,
//                ],
//                [
//                    'value'    => 'SAS',
//                    'key'      => 'contact.company_type.sas',
//                    'color'    => null,
//                    'position' => 2,
//                ],
//                [
//                    'value'    => 'SA',
//                    'key'      => 'contact.company_type.sa',
//                    'color'    => null,
//                    'position' => 3,
//                ],
//                [
//                    'value'    => 'SCI',
//                    'key'      => 'contact.company_type.sci',
//                    'color'    => null,
//                    'position' => 4,
//                ],
//            ],
//            /// COMPANY ORIGIN
//            'contact.origin'       => [
//                [
//                    'value'    => 'Pige',
//                    'key'      => 'contact.origin.pige',
//                    'color'    => null,
//                    'position' => 0,
//                ],
//                [
//                    'value'    => 'Apporteur',
//                    'key'      => 'contact.origin.apporteur',
//                    'color'    => null,
//                    'position' => 1,
//                ],
//                [
//                    'value'    => 'Connaissance',
//                    'key'      => 'contact.origin.connaissance',
//                    'color'    => null,
//                    'position' => 2,
//                ],
//                [
//                    'value'    => 'Prospection terrain',
//                    'key'      => 'contact.origin.prospection',
//                    'color'    => null,
//                    'position' => 3,
//                ],
//            ],
//            // PLAN DE COMMUNICATION
//            /// CATEGORY : Digital, Street marketing, Mixte
//            /*'com_plan.category' => [
//                [
//                    'value'         => 'Digitale',
//                    'key'           => 'com_plan.category.digital',
//                    'color'         => '#000000',
//                    'position'      => 0,
//                ],
//                [
//                    'value'         => 'Street marketing',
//                    'key'           => 'com_plan.category.street_marketing',
//                    'color'         => '#000000',
//                    'position'      => 1,
//                ],
//                [
//                    'value'         => 'Mixte',
//                    'key'           => 'com_plan.category.mixte',
//                    'color'         => '#000000',
//                    'position'      => 2,
//                ],
//            ],*/

        ];

        // First, define each generic attribute
        foreach ($attributesData as $attributeData)
        {

            $attributeKey = $attributeData['key'];
            $attribute = Attribute::where('key', '=', $attributeKey)->first();

            if ($attribute)
            {
                // UPDATE
                $attribute->update($attributeData);
                $this->command->info('Update attribute entry "' . $attributeKey . '"');
            } else
            {
                // CREATE
                $attribute = Attribute::create($attributeData);
                $this->command->info('Create attribute entry "' . $attributeKey . '"');
            }

            // Add/Update attribute_values
            if (isset($attributeValuesData[$attributeKey]))
            {
                foreach ($attributeValuesData[$attributeKey] as $attributeValueData)
                {
                    $attributeValueKey = $attributeValueData['key'];
                    $attributeValue = AttributeValue::where('key', '=', $attributeValueKey)->first();

                    $attributeValueData['attribute_id'] = $attribute->id;

                    if ($attributeValue)
                    {
                        // UPDATE
                        $attributeValue->update($attributeValueData);
                        $this->command->info('Update attribute_values entry "' . $attributeValueKey . '"');
                    } else
                    {
                        // CREATE
                        $attributeValue = AttributeValue::create($attributeValueData);
                        $this->command->info('Create attribute_values entry "' . $attributeValueKey . '"');
                    }

                    // Insert all attribute using old storage management (CONSTANT if available)
                    $keyExplode = explode('.', $attributeValueKey);
                    $constName = strtoupper(array_pop($keyExplode));
                    $constNameFull = $attribute->class_name . '::' . $constName;

                    if (defined($constNameFull))
                    {
                        $this->command->info("\tIMPORT values in attributables table from constant '" . $constNameFull . "'");

                        $constValue = constant($constNameFull);

                        // Search items with current const value
                        $keyExplode = explode('.', $attribute->key);
                        $fieldName = array_pop($keyExplode);
                        $query = call_user_func($attribute->class_name . '::where' . ucfirst($fieldName), $constValue);
                        $results = $query->get();

                        if ($results && $results->count() > 0)
                        {
                            $this->command->info("\tImport " . $results->count() . " values");
                            foreach ($results as $item)
                            {
                                $item->{$fieldName}()->sync([$attributeValue->id => ['field' => $fieldName]]);
                            }
                        } else
                        {
                            $this->command->info("\tNothing to import");
                        }

                    } else
                    {
                        $this->command->error(
                            '  => No matching to insert values in attributables table from constant "' . $constNameFull . '"'
                        );
                    }

                }
            }
        }
    }

}