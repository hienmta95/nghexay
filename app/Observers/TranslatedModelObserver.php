<?php


namespace App\Observer;


class TranslatedModelObserver
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param  \App\Models\Traits\TranslatedTrait $entry
	 * @return void
	 */
	public function deleting($entry)
	{
		if (isTranlatableModel($entry)) {
			// Delete the entry in other languages.
			$entry->deleteEntryInOtherLanguages();
		}
	}
	
	/**
	 * Listen to the Entry created event.
	 *
	 * @param  \App\Models\Traits\TranslatedTrait $entry
	 * @return void
	 */
	public function created($entry)
	{
		if (isTranlatableModel($entry)) {
			// Fix (or Set) the 'translation_of' field for the default language entry.
			$entry->setTranslationOfAttributeFromPrimaryKey();
			
			// Create (or Copy) the current entry in all other languages.
			$entry->createNonTranslatableFieldsInOtherLanguages();
		}
	}
	
	/**
	 * Listen to the Entry updated event.
	 *
	 * @param  \App\Models\Traits\TranslatedTrait $entry
	 * @return void
	 */
	public function updated($entry)
	{
		if (isTranlatableModel($entry)) {
			// Update all languages non-translatable entries fields, from the Default Language data.
			$entry->updateNonTranslatableFieldsInOtherLanguages();
		}
	}
}
