## Roadmap

- [ ] move all current code in legacy/, make main php file include legacy/wrap.php
      and adjust to maintain functionalties
- [ ] create main classes
    - [ ] Wrap: main class
    - [ ] Wrap_Client, the first part of the url:
          (as a large concept, they might simply refer to a group of projects), 
          Each client can have several projects, but the client page only displays 
          client data, or redirects to client's own website.
    - [ ] Wrap_Project, the second part of the url:
          shared between different people involved in the project. People
          given access to a project can see the whole subtree of the project, at
          least in readonly mode, but not other projects, even of the same client.
    - [ ] Wrap_Session: third part of the url:
          referred as "castings" in legacy code, usually daily additions in the project, to allow participants to clearly see new additions
    - [ ] directory, menu, file, video, image, player ...
    - [ ] playlists and/or selections: list of files to display on the page
    
      client, project, session, 
- (tbc)...
