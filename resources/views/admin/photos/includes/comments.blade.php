<div class="myy-table">
    <div class="container-fluid px-0">
      <div class="row g-5">
        <div class="col-12">
          <div class="myy-table__wrapper">
            <div class="myy-table__header">
              <div class="myy-table__title">
                <span class="text-muted mb-1 d-inline-flex align-items-center gap-2">Blog <i class="lni lni-chevron-right"></i> Comment</span>
                <h5 class="fs-3 fw-semibold mb-0">Comments</h5>
              </div>
              <div class="form-group d-flex gap-2">
                <a href="{{route('admin.blog-comments.create').'?blog_id='.$data->id}}" type="button" class="btn btn-primary">New Comment</a>
              </div>
            </div>
            <div class="myy-table__body">
              <div class="table__top align-items-start flex-lg-nowrap gap-lg-5">

                <div class="table__top-action justify-content-lg-end">
                  <div class="form-group">
                    <div class="search-item">
                      <input type="text" class="form-control" placeholder="Search..."
                        aria-label="Search">
                      <i class="lni lni-search-alt"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive">

                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">
                        <div class="form-check form-check--style2 form-check-md">
                          <input class="form-check-input" type="checkbox" value=""
                            id="selectAll">
                        </div>
                      </th>
                      <th scope="col">Name</th>
                      <th scope="col">Comment</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data->blogComments()->orderBy('id','desc')->get() as $key=>$blog_comment)
                    <tr data-id="{{$key}}">
                      <td>
                        <div class="form-check form-check--style2 form-check-md">
                          <input class="form-check-input rowCheckbox" type="checkbox" data-id="1">
                        </div>
                      </td>
                      <td>{{$blog_comment->name}}</td>
                      <td>
                        <span class="text-mute fs-6">{!!CutString($blog_comment->description,20)!!}</span>
                      </td>
                      <td>{{$blog_comment->status}}</td>
                      <td>
                        <ul class="myy-action__list">
                          <li class="myy-action">
                              <a class="myy-action__item myy-action__item--success"
                                  href="{{ route('admin.blog-comments.show', $blog_comment->id) }}">
                                  <i class="lni lni-eye"></i>
                              </a>
                          </li>
                          @can('blog-comment-update')
                              <li class="myy-action">
                                  <a class="myy-action__item myy-action__item--warning"
                                      href="{{ route('admin.blog-comments.edit', $blog_comment->id) }}">
                                      <i class="lni lni-pencil-alt"></i>
                                  </a>
                              </li>
                          @endcan
                          @can('blog-comment-delete')
                              <li class="myy-action">
                                  <a onclick="deleteCrudItem(`{{ route('admin.blog-comments.destroy', $blog_comment->id) }}`)"
                                      class="myy-action__item myy-action__item--danger" href="#">
                                      <i class="lni lni-trash-can"></i>
                                  </a>
                              </li>
                          @endcan
                      </ul>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>