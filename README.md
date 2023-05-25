## Comments Section

Fun Challenge!

Method for finding the fastest path explanation;
It maps out each direction from each cell, keeping count of the distance from the starting cell for each
direction it goes. It then adds valid cells to the process queue for continuing its pathing across
all valid routes. Once we find the cell we want to be at we have reached our "distance" for that specified route.

We know we have the fastest route since it moves 1 square in each path each time and processing all moves at once.
ie. It will process "move 3" (let's say right) at the same time as it is processing "move 3" for another
possible route (let's say left). The "move" that lands on the destination is the fastest because it's the first
that gets there in the process queue.

### What I'm Pleased With

n/a

### What I Would Have Done With More Time

Map generator for tests, more documentation, separate the tests to unit/feature.