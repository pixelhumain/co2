# Deleting an Element 

[doc](https://docs.google.com/presentation/d/1obBMnxSqsLo8Ij7GjaxyxF_zvZgYGAptfgT6MQxghME/edit#slide=id.g1a46cf7eb5_0_33)


- call js 
    - baseUrl+"/"+moduleId+"/element/delete/id/"+contextData.id+"/type/"+contextData.type;

- Element::askToDelete
    + $managedTypes
    + //retrieve admins of the element 
    + added on DB entry 
        * "status" : "deletePending",
        * "statusDate" : ISODate("2017-11-29T08:33:21.203Z"),
        * "reasonDelete" : "",
        * "userAskingToDelete" : "5996017c539f225123cb243c"

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

- Person::deletePerson 
-   //TODO SBAR : remove thumb and medium

- Clean up Cron job     
    + ctk/ctrler/cron/CheckDeletePendingAction
    + $type2check = array(
            Organization::COLLECTION, 
            Project::COLLECTION, 
            Event::COLLECTION);
    + uses const Element::NB_DAY_BEFORE_DELETE = 5;
