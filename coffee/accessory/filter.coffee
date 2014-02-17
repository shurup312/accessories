# если элемент пустой, то будем выдавать вместо описания "--"
angular.module('AccessoryDataFilter',[])
  .filter 'isempty',()->
    (input)->
      if input? then input else '--'