/** Selectioner toutes les missions **/
SELECT * from mission;

/** Selectioner le nombre de missions qui ont le même status et afficher les status de chacune en même temps **/
SELECT COUNT(*),name as missions_status FROM mission JOIN status s ON mission.status = s.id GROUP BY status

/** Modifier la mission d'un agent qui a le id 1 et lui assigner une autre mission de l'id 2 **/
UPDATE agent SET code='najib' WHERE id=1

/** Supprimer le contact de l'id 1  **/
DELETE FROM contact WHERE id=1