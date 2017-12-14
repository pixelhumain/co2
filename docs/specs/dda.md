# DDA : Discussion , Decision , Action 
> outil de gestion de communauté
https://docs.google.com/document/d/1RX-a5Os9sw7a9CMPCOOE1N3Q-P6XRxFL2NNZXrpWgWE/edit

## architecture spec
menu is build using ajax 
```
loadActionRoom()
/rooms/index/type/'+contextData.type+'/id/'+contextData.id
```

testing directory loading 
```
loadDataDirectory
ajax /element/getdatadetail/type....
```
### Rooms
 3 types listed in config/CO2/rooms.json
- discussion 
- decision 
- action 

created by 
```
dynForm dyFObj.openForm('room','sub')
```

according to type , rooms show differently 

Features :
- Archiving : 
- 

### Discussion 
on creation we redirect to the discussion wall 
Viewing Decision Room 
```
/co2/views/comments/commentPodActionRooms.php
```


### Decision 
in decisions you can create proposals
created by 
```
dynForm dyFObj.openForm('entry','sub')
uses : co2/assets/js/dynform/entry.js
```

hash on a organization 
```
#page.type.organizations.id.58220d0bf6ca47907cb6cb97.view.dda.dir.actions.idda.59846b00539f22935ca498ae
```

Viewing Decision Room 
```
/co2/views/survey/index.php
```

Viewing Decision Room Proposals
```
/co2/views/rooms/entryStandalone.php
```



### Actions
in decisions you can create actions
created by 
```
dynForm dyFObj.openForm('action','sub')
uses : co2/assets/js/dynform/action.js
```

hash on an organization 
```
#page.type.organizations.id.58220d0bf6ca47907cb6cb97.view.dda.dir.actions.idda.59846b00539f22935ca498ae
```

Viewing an Action Room
```
/co2/views/rooms/actionList.php
```

Viewing an Action
```
/co2/views/rooms/actionStandalone.php
```



V2 
co2/views/cooperation/action.ph 
