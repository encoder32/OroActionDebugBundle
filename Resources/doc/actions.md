Actions
=======

Table of Contents
-----------------
 - [Dump](#dump)

Dump `@dump`
------------------------------------

**Class:** Oro\Bundle\ActionDebugBundle\Action\Dump

**Alias:** dump

**Description:** Dump current context to Debug Toolbar

**Configuration Example**
```yml
# Resources/config/oro/actions.yml
operations:
    test_user_operation:
        label: Test Operation
        entities:
            - Oro\Bundle\UserBundle\Entity\User
        datagrids:
            - oro-users-grid
        preactions:
            - '@assign_value': [$.testId, $id]
            - '@assign_value': [$.myTrueVar, true]
            - '@assign_value': [$.myFalseVar, false]
            - '@dump': 'end preactions'
```
