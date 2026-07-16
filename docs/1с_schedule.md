# Расширение API расписания 1С (ScheduleUpdate)

---

## Enum’ы

| Поле        | Значения                                                   |
| ----------- | ---------------------------------------------------------- |
| `format`    | `clinic` — очно; `online` — дистанционно; `home` — на дому |
| `visitType` | `primary` — первичный; `repeat` — повторный                |

---

## 1. `nearestTimeWeekAll`

**Метод:** `action=nearestTimeWeekAll`
**Запрос сейчас:** `Klinika=<guid>`

### Текущий ответ

```json
[
	"15.07.2026 14:00_xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",
	"16.07.2026 10:00_yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy"
]
```

### Требуемый ответ (старое + новое)

```json
[
	{
		"nearest": "15.07.2026 14:00",
		"doctorGuid": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",
		"formats": ["clinic", "online", "home"]
	},
	{
		"nearest": "16.07.2026 10:00",
		"doctorGuid": "yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy",
		"formats": ["clinic"]
	}
]
```

### Новые поля

| Поле         | Тип      | Описание                                                   |
| ------------ | -------- | ---------------------------------------------------------- |
| `nearest`    | string   | Ближайший слот (`dd.mm.yyyy HH:mm`) — было в строке до `_` |
| `doctorGuid` | UUID     | GUID врача — было в строке после `_`                       |
| `formats`    | string[] | Доступные форматы: `clinic`, `online`, `home`              |

---

## 2. `getMonth`

**Метод:** `action=getMonth`
**Запрос сейчас:** `doctorid`, `month=Ym`, `Klinika`

### Текущий ответ

```json
["01.07.2026", "05.07.2026", "12.07.2026"]
```

### Требуемый ответ (старое + новое)

```json
[
	{
		"date": "01.07.2026",
		"formats": ["clinic", "online"],
		"visitTypes": ["primary", "repeat"]
	},
	{
		"date": "05.07.2026",
		"formats": ["clinic"],
		"visitTypes": ["primary"]
	}
]
```

### Новые поля (в ответе)

| Поле         | Тип      | Описание                                                   |
| ------------ | -------- | ---------------------------------------------------------- |
| `date`       | string   | Дата (`dd.mm.yyyy`) — было значением элемента массива      |
| `formats`    | string[] | Форматы, доступные в этот день: `clinic`, `online`, `home` |
| `visitTypes` | string[] | Типы приёма на день: `primary`, `repeat`                   |

### Новые поля (в запросе, опционально)

| Поле        | Значения  | Описание |
| ----------- | --------- | -------- | ------------------------- | --------------------- |
| `format`    | `clinic`  | `online` | `home`                    | Фильтр дат по формату |
| `visitType` | `primary` | `repeat` | Фильтр дат по типу приёма |

---

## 3. `get`

**Метод:** `action=get`
**Запрос сейчас:** `doctorid`, `date=YYYYMMDD`, `Klinika`

### Текущий ответ

```json
["09:00", "10:00", "14:00"]
```

### Требуемый ответ (старое + новое)

```json
[
	{
		"time": "09:00",
		"format": "clinic",
		"visitTypes": ["primary", "repeat"]
	},
	{
		"time": "09:30",
		"format": "online",
		"visitTypes": ["primary"]
	},
	{
		"time": "10:00",
		"format": "clinic",
		"visitTypes": ["repeat"]
	}
]
```

### Новые поля (в ответе)

| Поле         | Тип      | Описание                                                        |
| ------------ | -------- | --------------------------------------------------------------- |
| `time`       | string   | Время (`HH:mm`, в т.ч. `:30`) — было значением элемента массива |
| `format`     | string   | Формат слота: `clinic` / `online` / `home`                      |
| `visitTypes` | string[] | Для каких типов приёма слот доступен: `primary`, `repeat`       |

### Новые поля (в запросе, опционально)

| Поле        | Значения  | Описание |
| ----------- | --------- | -------- | ---------------------------- | ------------------------ |
| `format`    | `clinic`  | `online` | `home`                       | Фильтр слотов по формату |
| `visitType` | `primary` | `repeat` | Фильтр слотов по типу приёма |

---

## 4. `set` (запись к врачу)

**Метод:** `action=set`
**Запрос сейчас:** `doctorid`, `Klinika`, `patient`, `datetime`

### Текущий ответ

```
result: true, message: success
```

### Требуемый запрос (старые + новые поля)

```
action=set
&doctorid=<guid>
&Klinika=<guid>
&patient=79991234567
&datetime=202607151400
&format=online
&visitType=primary
&patientName=Иванов Иван Иванович
&patientEmail=ivan@example.com
```

### Требуемый ответ (старое + новое)

```json
{
	"result": true,
	"message": "success"
}
```

или

```json
{
	"result": false,
	"message": "slot_busy"
}
```

### Новые поля (в запросе)

| Поле           | Тип    | Описание                     |
| -------------- | ------ | ---------------------------- |
| `format`       | string | `clinic` / `online` / `home` |
| `visitType`    | string | `primary` / `repeat`         |
| `patientName`  | string | ФИО пациента                 |
| `patientEmail` | string | Email (опционально)          |

### Новые поля (в ответе)

Формально те же `result` / `message`, но в JSON.
`message` — коды ошибок, например: `slot_busy`, `slot_not_available_for_visit_type`.

---

## 5. Процедуры (опционально)

Если процедуры нельзя уложить в `set` — отдельные методы.
Если можно — добавить в `set` поле ниже.

### Новое поле запроса в `set`

| Поле          | Тип  | Описание                                                                                 |
| ------------- | ---- | ---------------------------------------------------------------------------------------- |
| `serviceGuid` | UUID | GUID процедуры/услуги; при наличии запись идёт как «на процедуру», `doctorid` опционален |
