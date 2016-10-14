angular.module('ui.bootstrap.demo', ['ui.bootstrap', 'iwg.lib.rest']).controller('TabsDemoCtrl', function ($scope, $window, librest) {
  $scope.user = {
    isAuthorized: true,
    logout: function() {
      setTimeout(function() {
        $window.alert('Logout function not implemented');
      });
    }
  };

  var getter = function(id){
      return this.list.find(function(item) { return item.id == id; });
  };

  $scope.categories = {
    list:[
      { id: 1, name: "Name 1" },
      { id: 2, name: "Name 2" },
      { id: 3, name: "Name 3" },
    ],
    current: {},
    get: getter,
    add: function(name) {
      var max = this.list.reduce(function(prev, cat){ return parseInt(cat.id) > prev ? parseInt(cat.id) : prev; }, 0);
      this.list.push( { id: max + 1, name: name } );
    },
    update: function(id, name) {
      var item = this.get(id);
      item.name = name;
    },
    delete: function(id) {
      var itemIndex = this.list.findIndex(function(item) { return item.id == id; });
      if (itemIndex >= 0) {
        this.list.splice(itemIndex, 1);
        this.current = this.list.length > 0 ? this.list[itemIndex < this.list.length ? itemIndex : this.list.length - 1] : {};
      }
    },
  };

  $scope.authors = {
    list:[
      { id: 1, name: "Author 1", fname: "FName 1", yearOfBirth: 1971 },
      { id: 2, name: "Author 2", fname: "FName 2", yearOfBirth: 1972 },
      { id: 3, name: "Author 3", fname: "FName 3", yearOfBirth: 1973 },
    ],
    current: {},
    get: getter,
    getByList: function(idList) {
      return this.list.filter(function(author){ return idList.indexOf(author.id) >= 0; });
    },
    getListCopy: function(){
      var dest = [];
      angular.copy(this.list, dest);
      return dest;
    },
    add: function(name, fname, yob) {
      var max = this.list.reduce(function(prev, cat){ return parseInt(cat.id) > prev ? parseInt(cat.id) : prev; }, 0);
      this.list.push( { id: max + 1, name: name, fname: fname, yearOfBirth: yob } );
    },
    update: function(id, name, fname, yob) {
      var item = this.get(id);
      angular.extend(item, {name: name, fname: fname, yearOfBirth: yob });
    },
    delete: function(id) {
      var itemIndex = this.list.findIndex(function(item) { return item.id == id; });
      if (itemIndex >= 0) {
        this.list.splice(itemIndex, 1);
        this.current = this.list.length > 0 ? this.list[itemIndex < this.list.length ? itemIndex : this.list.length - 1] : {};
      }
    },
  };

  $scope.books = {
    list:[
      { id: 1, name: "Book 1", year: 1991, category_id: 1, authors: [1] },
      { id: 2, name: "Book 2", year: 1992, category_id: 2, authors: [2] },
      { id: 3, name: "Book 3", year: 1993, category_id: 3, authors: [3] },
    ],
    bookAuthors: [],
    bookAuthorSelected: null,
    authorSrcList: [],
    authorSrcListSelected: null,
    current: null,
    categorySelected: null,
    get: getter,
    add: function(name, year, category_id, authors) {
      var max = this.list.reduce(function(prev, cat){ return parseInt(cat.id) > prev ? parseInt(cat.id) : prev; }, 0);
      this.list.push( { id: max + 1, name: name, year: year, category_id: category_id, authors: authors } );
    },
    update: function(id, name, year, category_id, authors) {
      var item = this.get(id);
      angular.extend(item, {name: name, year: year, category_id: category_id, authors: authors });
    },
    delete: function(id) {
      var itemIndex = this.list.findIndex(function(item) { return item.id == id; });
      if (itemIndex >= 0) {
        this.list.splice(itemIndex, 1);
        this.current = this.list.length > 0 ? this.list[itemIndex < this.list.length ? itemIndex : this.list.length - 1] : {};
      }
    },
    removeAuthor: function(author){
      var pos = this.bookAuthors.indexOf(author);
      if (pos >= 0) {
        this.authorSrcList.push(this.bookAuthors[pos]);
        this.bookAuthors.splice(pos, 1);
        this.bookAuthorSelected = pos < this.bookAuthors.length ? this.bookAuthors[pos] 
          : (this.bookAuthors.length > 0 ? this.bookAuthors.length : null);
      }
    },
    moveAuthorToBookList: function(authorId){
      if (!this.authorSrcList) {
        return;
      }
      var index = this.authorSrcList.findIndex(function(author){ return author.id == authorId; });
      if (index >= 0) {
        this.bookAuthors.push(this.authorSrcList[index]);  
        this.authorSrcList.splice(index, 1);
        this.authorSrcListSelected = index < this.authorSrcList.length ? this.authorSrcList[index] 
          : (this.authorSrcList.length > 0 ? this.authorSrcList[this.authorSrcList.length - 1] : null);
      }
    },
    assignAuthor: function(author) {
      this.moveAuthorToBookList(author.id);
    },
    fillBookAuthorList: function(idList){
      if (!idList) {
        return;
      }
      this.bookAuthors = [];
      idList.forEach(function(id){ 
        $scope.books.moveAuthorToBookList(id);
      });
    },
  };

  $scope.$watchCollection('books.current', function(newCurrent, oldCurrent) {
    if (newCurrent == null) {
      return;
    }
    $scope.books.categorySelected = $scope.categories.get(newCurrent.category_id);
    $scope.books.authorSrcList = $scope.authors.getListCopy();
    $scope.books.fillBookAuthorList(newCurrent.authors);
    $scope.books.bookAuthorSelected = $scope.books.bookAuthors.length > 0 ? $scope.books.bookAuthors[0] : null;
  });

  $scope.$watch('active', function(newTab, oldTab){
    console.log(newTab);
    //librest.sayHello("Hello from librest");
    librest.categories.getList(function(data){
      console.log(data);
    });
  });

});