# EavExerciseGetDobViaCli
An EAV exercise module: retrieve the customer DOB via CLI

```
> bin/magento sql:raw:query --email 'roni_cost@example.com'
Array
(
    [0] => Array
        (
            [dob] => 1973-12-15
        )

)

> bin/magento customer:repository:query --email 'roni_cost@example.com'
DoB = 1973-12-15
```
