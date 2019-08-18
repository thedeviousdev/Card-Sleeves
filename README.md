# Sleeved.io

The purpose of this site is to help all of the board game geeks out there sleeve their precious games!

##### **How to use it:**
- Type in the name of a game into the search bar
- Click the magnifying glass
_Results should appear with that game name (if they exist)_ 
- Click the image of the board game
- Select the brand of each sleeve 
- Click "Add Sleeves"
- Add all the games you need sleeved
- Cick the (❌) icon to remove a game from the "cart"

### **Game missing?**

 If you'd like a game to be added, post a new issue in the [Issues forum](https://github.com/thedeviousdev/Card-Sleeves/issues).
 
Set the post title to `[Request] Game Name`
 ```
**Game Name:** 
**Board Game Geek URL:** 
**Year/Edition:** (if possible)
```
 
 ### **Wrong/New information?**
 
 Most of the games have information provided by the gaming community, but it's possible it is incorrect or has not been added yet (sorry)! If you have the game in question, please help out and post a new issue in the [Issues forum](https://github.com/thedeviousdev/Card-Sleeves/issues). Follow the following format:
 
Set the post title to `[Update] Game Name`
```
**Game Name:** 
**Board Game Geek URL:** 
**Year/Edition:** (if possible)

**Sleeve Size 1**
**Quantity:**
**Width (mm):**
**Height (mm):**

**Sleeve Size 2**
**Quantity:**
**Width (mm):**
**Height (mm):**
```
_Add as many sleeve sizes as necessary_

### **Future Updates**
- Verify all games from BGG list
- Import user list from BGG
- Could not be added (from user Import)
- Allow a select community to update and add games themselves (Call out for contributors!)
- Allow community to update, and only allow a select view to 'verify'
- Add a "purchase" button that sends the user to Amazon (or other affiliates)
- Add sleeve colors to the names in the cart total
- Allow multiple of the same game to be added
- Style the "cart" a little better
- Link to expansions from base game
- Create an API endpoint for people to export this data
- Reverse search (I have "x" games, which sleeves will fit them)
- Show multiple images/videos of sleeved cards
- Analytics to see what are the most commonly searched games
- ~~Show edition/versions~~
- ~~Allow users to change the sleeve brand~~
- ~~Pop-up/lightbox to explain what the site is/how it works~~
- ~~Empty cart/clear all button~~
- ~~Show 'no results' response when searching~~
- ~~Add ALL of the games from BGG list~~
- ~~Lock down the edit pages by login~~

### Re-structuring the application

1. Allow users to register & login
 - Save game list
 - Suggest new games
 - Suggest changes to games
 - Comment on all games
 - Link account to BGG
 - Upvote users
2. Show game details
 - Image
 - Year
 - Edition
 - Number of players
 - Number of cards
 - Size of cards
 - Comments on game
 - Number of upvotes
 - Link to BGG
 - Affiliate links to buy games
 - Expansions
 - Select sleeve brand to add to cart
3. Search for games
 - By name
 - By player count
4. Add to cart
 - Select sleeve brand
 - Tally all sleeves
 - Affiliate purchase link
5. Update game
 - Update card values
 - Update edition
 - Update BGG link
 - Add/remove expansion
 - Update year
 - Update name
 - Update # of players
 - Delete game
 - Delete cards
6. Sleeve brands
 - Add brand name
 - Update brand name
 - Add sleeve size
 - Update sleeve size

### Image stuff

`for file in *.jpg; do convert $file -resize x300 -quality 80 $file; done`
`for file in *.png; do convert $file -resize x300 -quality 80 $file; done`

### **Thanks!**

Special thanks to the sleeving community! I have imported all the sleeves from the [Mayday Sleeves list](https://www.maydaygames.com/pages/sleeves-by-game) and am working through [Adam Kranzel's list on Board Game Geek](https://boardgamegeek.com/geeklist/164572/card-sleeve-sizes-games). I also use the [Board Game Geek's API](https://boardgamegeek.com/wiki/page/BGG_XML_API2) to pull in the data for new games. 
