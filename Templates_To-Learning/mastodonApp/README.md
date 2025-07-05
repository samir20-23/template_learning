**ActivityPub** is an open standard for decentralized social networking, allowing different platforms to communicate with each other. It enables users on different services (like Mastodon, PeerTube, or Pleroma) to interact with one another, share posts, and follow each other, without being tied to a single central server.

Here’s a breakdown of how ActivityPub works and its key components:

### 1. **Decentralization**  
ActivityPub enables a **federated** network, meaning that no one platform has full control. Different servers (or "instances") can run their own versions of a platform, but users across these instances can still interact with each other.

For example:
- If you have a Mastodon account, you can follow someone on a PeerTube instance and like their videos.
- If you're on one Mastodon server, you can follow users on another server seamlessly.

### 2. **Components of ActivityPub**  
There are two main parts of ActivityPub:

- **Actor**: Represents an individual user, group, or bot. This is the entity that performs actions like posting, following, or liking.
- **Activity**: Represents the actions that an actor can perform. These activities can be things like "Create" (for posting), "Like", "Follow", "Announce" (sharing posts), etc.

For example, when you post a message on a Mastodon instance:
- **Actor**: Your Mastodon account.
- **Activity**: Creating a post (a "Create" activity).
- **Object**: The content you wrote in the post.

### 3. **Communication**  
ActivityPub allows these "actors" to **send messages** to each other. For example:
- **Actor 1** (user on Instance A) creates a post.
- **Actor 2** (user on Instance B) likes the post.
- These activities are **federated**, meaning they are sent between different servers, and both users can see the interaction even if they are on different platforms or instances.

### 4. **Use Cases**  
- **Microblogging**: Mastodon uses ActivityPub for decentralized social networking, similar to Twitter.
- **Video Hosting**: PeerTube, a decentralized video platform, uses ActivityPub to share and follow videos across instances.
- **Social Networks**: Pleroma, Friendica, and other platforms also use ActivityPub for federated networking.

### Example: Simple Interaction

Let’s say you want to **like** a post from a user on another server:

1. **Actor**: You (the user).
2. **Activity**: Liking a post (the "Like" action).
3. **Object**: The post you are liking, which is stored on another server.

ActivityPub allows the "like" activity to be sent from your server to the other server where the post is located. The user who made the post will see your interaction, even though you’re on different platforms.

### How to Use ActivityPub in Development

If you want to implement ActivityPub in your own application, here’s an overview of what you'd do:

1. **Set up an Actor**: Define a user (an actor) who can send activities (e.g., post updates, follow other users).
2. **Send Activities**: Use HTTP requests (like **POST**) to send "activities" to other servers. For example, sending a "Create" activity to post a message.
3. **Receive Activities**: Implement endpoints to receive and process activities from other servers, like following users or liking posts.

### Tools & Libraries

- **Mastodon**: One of the most well-known platforms using ActivityPub.
- **Pleroma**: Another ActivityPub-based microblogging platform.
- **Friendica**: Social networking platform that supports ActivityPub.
- **Gancio**: A lightweight, ActivityPub-compatible server for federated communications.

### Installation Example (Mastodon)

If you wanted to install **Mastodon** (a popular federated platform using ActivityPub), here are the steps:

1. **Requirements**: You’ll need a server with **Ruby**, **PostgreSQL**, **Node.js**, and **Redis**.
2. **Install Dependencies**:
   - Install Ruby, PostgreSQL, and other required packages (using commands like `apt-get` for Ubuntu).
   - Install Node.js (for compiling front-end assets).
3. **Clone the Repository**:
   ```bash
   git clone https://github.com/mastodon/mastodon.git
   cd mastodon
   ```
4. **Set Up Configuration**:
   - Copy example files and edit for your server settings:
     ```bash
     cp .env.production.sample .env.production
     ```
5. **Install**:
   ```bash
   bundle install
   yarn install
   rails db:setup
   ```
6. **Start the Server**:
   ```bash
   rails server
   ```

This will set up Mastodon on your server, enabling you to interact with the federated network using ActivityPub.

### Summary

ActivityPub allows for decentralized social networks, where users on different platforms can still communicate, follow, and interact. It’s used by platforms like Mastodon, PeerTube, and others to create a federated network of social media services.

Let me know if you want more details on specific aspects, like installation or more examples!> [!NOTE]
> Want to learn more about Mastodon?
> Click below to find out more in a video.

<p align="center">
  <a style="text-decoration:none" href="https://www.youtube.com/watch?v=IPSbNdBmWKE">
    <img alt="Mastodon hero image" src="https://github.com/user-attachments/assets/ef53f5e9-c0d8-484d-9f53-00efdebb92c3" />
  </a>
</p>

<p align="center">
  <a style="text-decoration:none" href="https://github.com/mastodon/mastodon/releases">
    <img src="https://img.shields.io/github/release/mastodon/mastodon.svg" alt="Release" /></a>
  <a style="text-decoration:none" href="https://github.com/mastodon/mastodon/actions/workflows/test-ruby.yml">
    <img src="https://github.com/mastodon/mastodon/actions/workflows/test-ruby.yml/badge.svg" alt="Ruby Testing" /></a>
  <a style="text-decoration:none" href="https://crowdin.com/project/mastodon">
    <img src="https://d322cqt584bo4o.cloudfront.net/mastodon/localized.svg" alt="Crowdin" /></a>
</p>

Mastodon is a **free, open-source social network server** based on ActivityPub where users can follow friends and discover new ones. On Mastodon, users can publish anything they want: links, pictures, text, and video. All Mastodon servers are interoperable as a federated network (users on one server can seamlessly communicate with users from another one, including non-Mastodon software that implements ActivityPub!)

## Navigation

- [Project homepage 🐘](https://joinmastodon.org)
- [Support the development via Patreon][patreon]
- [View sponsors](https://joinmastodon.org/sponsors)
- [Blog](https://blog.joinmastodon.org)
- [Documentation](https://docs.joinmastodon.org)
- [Roadmap](https://joinmastodon.org/roadmap)
- [Official Docker image](https://github.com/mastodon/mastodon/pkgs/container/mastodon)
- [Browse Mastodon servers](https://joinmastodon.org/communities)
- [Browse Mastodon apps](https://joinmastodon.org/apps)

[patreon]: https://www.patreon.com/mastodon

## Features

<img src="/app/javascript/images/elephant_ui_working.svg?raw=true" align="right" width="30%" />

**No vendor lock-in: Fully interoperable with any conforming platform** - It doesn't have to be Mastodon; whatever implements ActivityPub is part of the social network! [Learn more](https://blog.joinmastodon.org/2018/06/why-activitypub-is-the-future/)

**Real-time, chronological timeline updates** - updates of people you're following appear in real-time in the UI via WebSockets. There's a firehose view as well!

**Media attachments like images and short videos** - upload and view images and WebM/MP4 videos attached to the updates. Videos with no audio track are treated like GIFs; normal videos loop continuously!

**Safety and moderation tools** - Mastodon includes private posts, locked accounts, phrase filtering, muting, blocking, and all sorts of other features, along with a reporting and moderation system. [Learn more](https://blog.joinmastodon.org/2018/07/cage-the-mastodon/)

**OAuth2 and a straightforward REST API** - Mastodon acts as an OAuth2 provider, so 3rd party apps can use the REST and Streaming APIs. This results in a rich app ecosystem with a lot of choices!

## Deployment

### Tech stack

- **Ruby on Rails** powers the REST API and other web pages
- **React.js** and **Redux** are used for the dynamic parts of the interface
- **Node.js** powers the streaming API

### Requirements

- **PostgreSQL** 12+
- **Redis** 4+
- **Ruby** 3.2+
- **Node.js** 18+

The repository includes deployment configurations for **Docker and docker-compose** as well as specific platforms like **Heroku**, and **Scalingo**. For Helm charts, reference the [mastodon/chart repository](https://github.com/mastodon/chart). The [**standalone** installation guide](https://docs.joinmastodon.org/admin/install/) is available in the documentation.

## Contributing

Mastodon is **free, open-source software** licensed under **AGPLv3**.

You can open issues for bugs you've found or features you think are missing. You
can also submit pull requests to this repository or translations via Crowdin. To
get started, look at the [CONTRIBUTING] and [DEVELOPMENT] guides. For changes
accepted into Mastodon, you can request to be paid through our [OpenCollective].

**IRC channel**: #mastodon on [`irc.libera.chat`](https://libera.chat)

## License

Copyright (c) 2016-2024 Eugen Rochko (+ [`mastodon authors`](AUTHORS.md))

Licensed under GNU Affero General Public License as stated in the [LICENSE](LICENSE):

```
Copyright (c) 2016-2024 Eugen Rochko & other Mastodon contributors

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU Affero General Public License as published by the Free
Software Foundation, either version 3 of the License, or (at your option) any
later version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
details.

You should have received a copy of the GNU Affero General Public License along
with this program. If not, see https://www.gnu.org/licenses/
```

[CONTRIBUTING]: CONTRIBUTING.md
[DEVELOPMENT]: docs/DEVELOPMENT.md
[OpenCollective]: https://opencollective.com/mastodon
**ActivityPub** is an open standard for decentralized social networking, allowing different platforms to communicate with each other. It enables users on different services (like Mastodon, PeerTube, or Pleroma) to interact with one another, share posts, and follow each other, without being tied to a single central server.

Here’s a breakdown of how ActivityPub works and its key components:

### 1. **Decentralization**  
ActivityPub enables a **federated** network, meaning that no one platform has full control. Different servers (or "instances") can run their own versions of a platform, but users across these instances can still interact with each other.

For example:
- If you have a Mastodon account, you can follow someone on a PeerTube instance and like their videos.
- If you're on one Mastodon server, you can follow users on another server seamlessly.

### 2. **Components of ActivityPub**  
There are two main parts of ActivityPub:

- **Actor**: Represents an individual user, group, or bot. This is the entity that performs actions like posting, following, or liking.
- **Activity**: Represents the actions that an actor can perform. These activities can be things like "Create" (for posting), "Like", "Follow", "Announce" (sharing posts), etc.

For example, when you post a message on a Mastodon instance:
- **Actor**: Your Mastodon account.
- **Activity**: Creating a post (a "Create" activity).
- **Object**: The content you wrote in the post.

### 3. **Communication**  
ActivityPub allows these "actors" to **send messages** to each other. For example:
- **Actor 1** (user on Instance A) creates a post.
- **Actor 2** (user on Instance B) likes the post.
- These activities are **federated**, meaning they are sent between different servers, and both users can see the interaction even if they are on different platforms or instances.

### 4. **Use Cases**  
- **Microblogging**: Mastodon uses ActivityPub for decentralized social networking, similar to Twitter.
- **Video Hosting**: PeerTube, a decentralized video platform, uses ActivityPub to share and follow videos across instances.
- **Social Networks**: Pleroma, Friendica, and other platforms also use ActivityPub for federated networking.

### Example: Simple Interaction

Let’s say you want to **like** a post from a user on another server:

1. **Actor**: You (the user).
2. **Activity**: Liking a post (the "Like" action).
3. **Object**: The post you are liking, which is stored on another server.

ActivityPub allows the "like" activity to be sent from your server to the other server where the post is located. The user who made the post will see your interaction, even though you’re on different platforms.

### How to Use ActivityPub in Development

If you want to implement ActivityPub in your own application, here’s an overview of what you'd do:

1. **Set up an Actor**: Define a user (an actor) who can send activities (e.g., post updates, follow other users).
2. **Send Activities**: Use HTTP requests (like **POST**) to send "activities" to other servers. For example, sending a "Create" activity to post a message.
3. **Receive Activities**: Implement endpoints to receive and process activities from other servers, like following users or liking posts.

### Tools & Libraries

- **Mastodon**: One of the most well-known platforms using ActivityPub.
- **Pleroma**: Another ActivityPub-based microblogging platform.
- **Friendica**: Social networking platform that supports ActivityPub.
- **Gancio**: A lightweight, ActivityPub-compatible server for federated communications.

### Installation Example (Mastodon)

If you wanted to install **Mastodon** (a popular federated platform using ActivityPub), here are the steps:

1. **Requirements**: You’ll need a server with **Ruby**, **PostgreSQL**, **Node.js**, and **Redis**.
2. **Install Dependencies**:
   - Install Ruby, PostgreSQL, and other required packages (using commands like `apt-get` for Ubuntu).
   - Install Node.js (for compiling front-end assets).
3. **Clone the Repository**:
   ```bash
   git clone https://github.com/mastodon/mastodon.git
   cd mastodon
   ```
4. **Set Up Configuration**:
   - Copy example files and edit for your server settings:
     ```bash
     cp .env.production.sample .env.production
     ```
5. **Install**:
   ```bash
   bundle install
   yarn install
   rails db:setup
   ```
6. **Start the Server**:
   ```bash
   rails server
   ```

This will set up Mastodon on your server, enabling you to interact with the federated network using ActivityPub.

### Summary

ActivityPub allows for decentralized social networks, where users on different platforms can still communicate, follow, and interact. It’s used by platforms like Mastodon, PeerTube, and others to create a federated network of social media services.

Let me know if you want more details on specific aspects, like installation or more examples!> [!NOTE]
> Want to learn more about Mastodon?
> Click below to find out more in a video.

<p align="center">
  <a style="text-decoration:none" href="https://www.youtube.com/watch?v=IPSbNdBmWKE">
    <img alt="Mastodon hero image" src="https://github.com/user-attachments/assets/ef53f5e9-c0d8-484d-9f53-00efdebb92c3" />
  </a>
</p>

<p align="center">
  <a style="text-decoration:none" href="https://github.com/mastodon/mastodon/releases">
    <img src="https://img.shields.io/github/release/mastodon/mastodon.svg" alt="Release" /></a>
  <a style="text-decoration:none" href="https://github.com/mastodon/mastodon/actions/workflows/test-ruby.yml">
    <img src="https://github.com/mastodon/mastodon/actions/workflows/test-ruby.yml/badge.svg" alt="Ruby Testing" /></a>
  <a style="text-decoration:none" href="https://crowdin.com/project/mastodon">
    <img src="https://d322cqt584bo4o.cloudfront.net/mastodon/localized.svg" alt="Crowdin" /></a>
</p>

Mastodon is a **free, open-source social network server** based on ActivityPub where users can follow friends and discover new ones. On Mastodon, users can publish anything they want: links, pictures, text, and video. All Mastodon servers are interoperable as a federated network (users on one server can seamlessly communicate with users from another one, including non-Mastodon software that implements ActivityPub!)

## Navigation

- [Project homepage 🐘](https://joinmastodon.org)
- [Support the development via Patreon][patreon]
- [View sponsors](https://joinmastodon.org/sponsors)
- [Blog](https://blog.joinmastodon.org)
- [Documentation](https://docs.joinmastodon.org)
- [Roadmap](https://joinmastodon.org/roadmap)
- [Official Docker image](https://github.com/mastodon/mastodon/pkgs/container/mastodon)
- [Browse Mastodon servers](https://joinmastodon.org/communities)
- [Browse Mastodon apps](https://joinmastodon.org/apps)

[patreon]: https://www.patreon.com/mastodon

## Features

<img src="/app/javascript/images/elephant_ui_working.svg?raw=true" align="right" width="30%" />

**No vendor lock-in: Fully interoperable with any conforming platform** - It doesn't have to be Mastodon; whatever implements ActivityPub is part of the social network! [Learn more](https://blog.joinmastodon.org/2018/06/why-activitypub-is-the-future/)

**Real-time, chronological timeline updates** - updates of people you're following appear in real-time in the UI via WebSockets. There's a firehose view as well!

**Media attachments like images and short videos** - upload and view images and WebM/MP4 videos attached to the updates. Videos with no audio track are treated like GIFs; normal videos loop continuously!

**Safety and moderation tools** - Mastodon includes private posts, locked accounts, phrase filtering, muting, blocking, and all sorts of other features, along with a reporting and moderation system. [Learn more](https://blog.joinmastodon.org/2018/07/cage-the-mastodon/)

**OAuth2 and a straightforward REST API** - Mastodon acts as an OAuth2 provider, so 3rd party apps can use the REST and Streaming APIs. This results in a rich app ecosystem with a lot of choices!

## Deployment

### Tech stack

- **Ruby on Rails** powers the REST API and other web pages
- **React.js** and **Redux** are used for the dynamic parts of the interface
- **Node.js** powers the streaming API

### Requirements

- **PostgreSQL** 12+
- **Redis** 4+
- **Ruby** 3.2+
- **Node.js** 18+

The repository includes deployment configurations for **Docker and docker-compose** as well as specific platforms like **Heroku**, and **Scalingo**. For Helm charts, reference the [mastodon/chart repository](https://github.com/mastodon/chart). The [**standalone** installation guide](https://docs.joinmastodon.org/admin/install/) is available in the documentation.

## Contributing

Mastodon is **free, open-source software** licensed under **AGPLv3**.

You can open issues for bugs you've found or features you think are missing. You
can also submit pull requests to this repository or translations via Crowdin. To
get started, look at the [CONTRIBUTING] and [DEVELOPMENT] guides. For changes
accepted into Mastodon, you can request to be paid through our [OpenCollective].

**IRC channel**: #mastodon on [`irc.libera.chat`](https://libera.chat)

## License

Copyright (c) 2016-2024 Eugen Rochko (+ [`mastodon authors`](AUTHORS.md))

Licensed under GNU Affero General Public License as stated in the [LICENSE](LICENSE):

```
Copyright (c) 2016-2024 Eugen Rochko & other Mastodon contributors

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU Affero General Public License as published by the Free
Software Foundation, either version 3 of the License, or (at your option) any
later version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
details.

You should have received a copy of the GNU Affero General Public License along
with this program. If not, see https://www.gnu.org/licenses/
```

[CONTRIBUTING]: CONTRIBUTING.md
[DEVELOPMENT]: docs/DEVELOPMENT.md
[OpenCollective]: https://opencollective.com/mastodon
