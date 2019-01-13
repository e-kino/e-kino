# Get showings by date

Get programme and its showings by date

**URL** : `/showings/{date}`

**Method** : `GET`

**Auth required** : NO

**Permissions required** : None

## Success Response

**Code** : `200 OK`

**Content examples**


```json
{
  "showings": [
    {
      "id": 1,
      "dateAdd": "2019-01-13 13:57:38",
      "timeShow": "10:00",
      "movie": {
        "id": 1,
        "name": "First",
        "description": null,
        "age": null,
        "date_add": "2019-01-13 14:52:56"
      }
    }
  ]
}
```
