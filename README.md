## 📋General

<img src="https://github.com/ClickedTran/GiftCode/blob/Master/icon.jpg" align="center">

<br>
<p align="center">This is a Plugin that allows Admin to generate a giftcode for the server with optional time and rewards</p>
<br>

## 📖Feature
- This is a Plugin that allows Admin to generate a giftcode for the server with optional time and rewards
- Supported currencies: `EconomyAPI`, `PointAPI`, `CoinAPI`, `BedrockEconomy`
- Can't support `items` and `blocks`, (maybe it will be updated to `4.0.0` version of plugin soon!)
<b>

## 📚For Developer

- You can access to GiftCode by using
- You can usage to:
<details>
  <summary>Click To See</summary>
  
  >- Create New GiftCode:

  ```php
  GiftCode::getInstance()->createCode(string $name, int $day, int $hour, int $minute, int $second, string $type, int $amount);
  ```

  >- Remove GiftCode:
  ```php
   GiftCode::getInstance()->removeCode(string $name);
  ```
</details>
<br>

## 💬Command & Permission
| **COMMANDS** | **ALIASES** | **SUBCOMMAND** | **DESCRIPTION** | **PERMISSION** | **DEFAULT** |
| --- | --- | --- | --- | --- | --- |
| | | `Used to open menu input giftcode` | `giftcode.command` | `true` |
| | | `create` | `Used to create new giftcode for data` | `giftcode.command.create` | `op` |
| `giftcode` | `code` | `remove` | `Used to delete existing giftcodes in the data` | `giftcode.command.remove` | `op` |
| | | `list` | `Used to see the existing giftcodes in the data` | `giftcode.command.list` | `op` |
| | | `help` | `Used to view the above commands` | `giftcode.command.help` | `op` |
