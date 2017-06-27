Conditions
==========

Table of Contents
-----------------
 - [Dump Condition](#dump-condition)

Dump Condition
--------------

**Aliases:** dump_true, dump_false

**Description:** Dump current context into Debug Toolbar and return TRUE or FALSE result.

**Options:**
 - Label

**Code Example**

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
        preconditions:
            '@and':
                - '@dump_true': 'preconditions'
                - '@gt': [$.testId, 10]
```
