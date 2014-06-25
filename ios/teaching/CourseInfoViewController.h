//
//  CourseInfoViewController.h
//  teaching
//
//  Created by merlin on 13-12-19.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import "BaseViewController.h"
#import "LoginViewController.h"
#import "CommonViewController.h"


@interface CourseInfoViewController : BaseViewController <LoginCallbackDelegate>
{
    BOOL isBuyed;
}

@property ( nonatomic , retain) NSURL *courseUrl;

- (id) initWithUrl:(NSURL *) url;
@end
