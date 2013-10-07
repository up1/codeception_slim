<?php
interface WineDao{
  function getWines();
  function getWine($id);
  function addWine($wine);
  function updateWine($id, $wine);
  function deleteWine($id);
}
