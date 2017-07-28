# Deleting an Element 

- Element::deleteElement($elementType, $elementId, $reason, $userId) 
    - self::getByTypeAndId
    - Document::listMyDocumentByIdAndType
        + Document::removeDocumentById
    - ActivityStream::removeElementActivityStream
    - News::deleteNewsOfElement
        + get all news for elem
        + for each News::delete
            * $authorization=self::canAdministrate
            * Delete Images if exist
            * PHDB::remove(Comment::COLLECTION,
            * efface les activityStream lié à la news
            * Comment::deleteAllContextComments
    - ActionRoom::deleteElementActionRooms
    - Remove backwards links :: $elementToDelete["links"]
    - Unset the organizer for events organized by the element
    - Unset the project with parent this element
    - Notification::constructNotification
    - Delete the element :: PHDB::remove($elementType, $where) 
    - Log::save
